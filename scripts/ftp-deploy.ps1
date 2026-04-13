<#
.SYNOPSIS
  Upload production Laravel + built SPA assets via FTP/FTPS (port 21, explicit TLS).

.DESCRIPTION
  Uploads only runtime paths: app, bootstrap (no cached PHP), config, database, public,
  resources, routes, storage skeleton, plus artisan and composer files.
  Does NOT upload: vendor, node_modules, frontend sources, tests, .env, sqlite DBs, logs.

  Optional config: copy ftp-deploy.config.example.ps1 -> ftp-deploy.config.ps1 and edit.
  Password: set in config file OR environment variable FTP_DEPLOY_PASSWORD (overrides file).

.EXAMPLE
  .\scripts\ftp-deploy.ps1
  $env:FTP_DEPLOY_PASSWORD = 'secret'; .\scripts\ftp-deploy.ps1
  .\scripts\ftp-deploy.ps1 -DryRun
#>

[CmdletBinding()]
param(
    [switch] $DryRun,
    [switch] $IncludeVendor
)

$ErrorActionPreference = 'Stop'

$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$RepoRoot  = Split-Path -Parent $ScriptDir

# Defaults (override with ftp-deploy.config.ps1)
$script:FtpServer   = 'ftp.eimtbd.com'
$script:FtpPort     = 21
$script:FtpUsername = 'gg@gg.eimtbd.com'
$script:FtpPassword = 'YOUR_FTP_PASSWORD_HERE'
# Empty = upload into the FTP account home (the folder you see at login — your web deploy root). Set only if files must go under a subpath, e.g. /public_html
$script:RemoteBasePath = ''
$script:UseExplicitFtps = $true
$script:TrustAnyTlsCertificate = $false

$cfg = Join-Path $ScriptDir 'ftp-deploy.config.ps1'
if (Test-Path -LiteralPath $cfg) {
    . $cfg
}

$pass = $env:FTP_DEPLOY_PASSWORD
if ([string]::IsNullOrWhiteSpace($pass)) { $pass = $script:FtpPassword }
if ($pass -eq 'YOUR_FTP_PASSWORD_HERE' -or [string]::IsNullOrWhiteSpace($pass)) {
    throw 'Set FTP_DEPLOY_PASSWORD in the environment, or set FtpPassword in scripts/ftp-deploy.config.ps1 (copy from ftp-deploy.config.example.ps1).'
}

$rb = ($script:RemoteBasePath -replace '\\', '/').Trim()
if ([string]::IsNullOrWhiteSpace($rb) -or $rb -eq '.') {
    $remoteBase = ''
} else {
    $remoteBase = $rb.TrimEnd('/')
    if (-not $remoteBase.StartsWith('/')) { $remoteBase = "/$remoteBase" }
}

if ($script:TrustAnyTlsCertificate) {
    [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $true }
}

function Get-FtpUri([string] $RemotePath) {
    $p = ($RemotePath -replace '\\', '/')
    if (-not $p.StartsWith('/')) { $p = "/$p" }
    return "ftp://$($script:FtpServer):$($script:FtpPort)$p"
}

function Invoke-FtpRequest {
    param(
        [string] $RemotePath,
        [string] $Method,
        [byte[]] $FileBytes = $null
    )
    $uri = Get-FtpUri -RemotePath $RemotePath
    $req = [System.Net.FtpWebRequest]::Create($uri)
    $req = [System.Net.FtpWebRequest]$req
    $req.Credentials = New-Object System.Net.NetworkCredential($script:FtpUsername, $pass)
    $req.EnableSsl = [bool]$script:UseExplicitFtps
    $req.UseBinary = $true
    $req.UsePassive = $true
    $req.KeepAlive = $false
    $req.Method = $Method
    if ($null -ne $FileBytes) {
        $req.ContentLength = $FileBytes.Length
        $rs = $req.GetRequestStream()
        try {
            $rs.Write($FileBytes, 0, $FileBytes.Length)
        } finally {
            $rs.Close()
        }
    }
    $resp = $req.GetResponse()
    try { $resp.Close() } catch {}
}

function Ensure-FtpDirectory([string] $RemoteDir) {
    $RemoteDir = ($RemoteDir -replace '\\', '/').TrimEnd('/')
    if (-not $RemoteDir.StartsWith('/')) { $RemoteDir = "/$RemoteDir" }
    $full = "$remoteBase$RemoteDir"
    $parts = $full.Trim('/').Split('/', [System.StringSplitOptions]::RemoveEmptyEntries)
    $acc = ''
    foreach ($seg in $parts) {
        $acc = "$acc/$seg"
        try {
            Invoke-FtpRequest -RemotePath $acc -Method ([System.Net.WebRequestMethods+Ftp]::MakeDirectory)
        } catch {
            # 550 = exists on many servers
        }
    }
}

function Upload-OneFile([string] $LocalPath, [string] $RemotePath) {
    $RemotePath = ($RemotePath -replace '\\', '/')
    if (-not $RemotePath.StartsWith('/')) { $RemotePath = "/$RemotePath" }
    $dest = "$remoteBase$RemotePath"
    $dir = Split-Path -Parent $dest
    if ($dir) {
        Ensure-FtpDirectory -RemoteDir ($dir.Substring($remoteBase.Length))
    }
    $bytes = [System.IO.File]::ReadAllBytes($LocalPath)
    Invoke-FtpRequest -RemotePath $dest -Method ([System.Net.WebRequestMethods+Ftp]::UploadFile) -FileBytes $bytes
}

function Test-ShouldSkipFile([string] $FullPath) {
    $rel = $FullPath.Substring($RepoRoot.Length).TrimStart('\', '/')
    $norm = $rel -replace '/', '\'
    $lower = $norm.ToLowerInvariant()

    if ($lower -match '\\vendor\\') { return -not $IncludeVendor }
    if ($lower -match '\\node_modules\\') { return $true }
    if ($lower -match '\\frontend\\') { return $true }
    if ($lower -match '\\tests\\') { return $true }
    if ($lower -match '\\\.git\\') { return $true }
    if ($lower -match '\\\.idea\\') { return $true }
    if ($lower -match '\\\.vscode\\') { return $true }
    if ($lower -match '\\storage\\logs\\' -and $lower -match '\.log$') { return $true }
    if ($lower -match '\.sqlite($|\.)') { return $true }
    if ($lower -match '\\bootstrap\\cache\\' -and $lower -match '\.php$') { return $true }
    if ($lower -match '\\\.env') { return $true }

    return $false
}

$dirMappings = @(
    @{ Rel = 'app' },
    @{ Rel = 'bootstrap' },
    @{ Rel = 'config' },
    @{ Rel = 'database' },
    @{ Rel = 'public' },
    @{ Rel = 'resources' },
    @{ Rel = 'routes' },
    @{ Rel = 'storage' }
)

$rootFiles = @('artisan', 'composer.json', 'composer.lock')

Write-Host "Repo: $RepoRoot"
if ($remoteBase) {
    Write-Host "Remote:  ftp://$($script:FtpServer)$remoteBase (prefix under FTP home)"
} else {
    Write-Host "Remote:  ftp://$($script:FtpServer)/ (FTP login folder = deploy root; app, public, … uploaded there)"
}
Write-Host "FTPS:    $($script:UseExplicitFtps)"
Write-Host "DryRun:  $DryRun"
Write-Host ""

$dist = Join-Path $RepoRoot 'public\dist'
if (-not (Test-Path -LiteralPath $dist)) {
    Write-Warning "public/dist not found. Run: cd frontend; npm ci; npm run build"
} else {
    $manifest = Join-Path $dist '.vite\manifest.json'
    if (-not (Test-Path -LiteralPath $manifest)) {
        Write-Warning "public/dist/.vite/manifest.json missing — SPA build may be incomplete."
    }
}
Write-Host ""

$uploadList = New-Object System.Collections.Generic.List[object]

foreach ($m in $dirMappings) {
    $localDir = Join-Path $RepoRoot $m.Rel
    if (-not (Test-Path -LiteralPath $localDir)) { continue }
    Get-ChildItem -LiteralPath $localDir -Recurse -File -Force | ForEach-Object {
        $rel = $_.FullName.Substring($RepoRoot.Length).TrimStart('\', '/')
        $relFwd = $rel -replace '\\', '/'
        if (Test-ShouldSkipFile -FullPath $_.FullName) { return }
        $uploadList.Add([pscustomobject]@{ Local = $_.FullName; Remote = "/$relFwd" })
    }
}

foreach ($rf in $rootFiles) {
    $p = Join-Path $RepoRoot $rf
    if (Test-Path -LiteralPath $p) {
        if (-not (Test-ShouldSkipFile -FullPath $p)) {
            $uploadList.Add([pscustomobject]@{ Local = $p; Remote = "/$rf" })
        }
    }
}

Write-Host "Files to upload: $($uploadList.Count)"
if ($DryRun) {
    $uploadList | Select-Object -First 50 | ForEach-Object { Write-Host "  $($_.Remote)" }
    if ($uploadList.Count -gt 50) { Write-Host "  ... ($($uploadList.Count - 50) more)" }
    exit 0
}

$i = 0
foreach ($item in $uploadList) {
    $i++
    if (($i % 25) -eq 1 -or $i -eq $uploadList.Count) {
        Write-Host "[$i/$($uploadList.Count)] $($item.Remote)"
    }
    Upload-OneFile -LocalPath $item.Local -RemotePath $item.Remote
}

Write-Host ""
Write-Host "Done. On the server: composer install --no-dev --optimize-autoloader"
Write-Host "Copy .env, php artisan key:generate, migrate, and ensure storage & bootstrap/cache are writable."
$pubHint = if ($remoteBase) { "$remoteBase/public" } else { 'public (under your FTP home, next to app and config)' }
Write-Host "Point the website document root at: $pubHint. Set APP_URL / ASSET_URL in .env if URLs differ."

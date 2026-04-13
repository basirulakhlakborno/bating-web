# Copy to ftp-deploy.config.ps1 (same folder) and adjust. Do not commit ftp-deploy.config.ps1.
# ftp-deploy.config.ps1 is loaded automatically if present.

$script:FtpServer = 'ftp.eimtbd.com'
$script:FtpPort     = 21
$script:FtpUsername = 'gg@gg.eimtbd.com'
# Paste your password here, or leave empty and set environment variable FTP_DEPLOY_PASSWORD before running.
$script:FtpPassword = 'YOUR_FTP_PASSWORD_HERE'

# Leave empty ('') so uploads go to the FTP account home — the folder that opens when you connect (your web deploy root).
# Set a subpath only if the host puts you above the site, e.g. '/public_html'
$script:RemoteBasePath = ''

# Use explicit FTPS (AUTH TLS). Set $false only if your host requires plain FTP.
$script:UseExplicitFtps = $true

# Trust any TLS certificate (some shared hosts use mismatched certs). $false is safer.
$script:TrustAnyTlsCertificate = $false

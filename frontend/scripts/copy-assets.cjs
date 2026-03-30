/**
 * Copy Laravel `public/css`, `public/static`, and `public/fonts` into this app's `public/`
 * so Vite serves the same bundles and assets (run from repo: npm run copy:assets).
 *
 * `chunk-vendors.*.css` references webpack content-hashed MDI filenames (e.g.
 * `materialdesignicons-webfont.d0066537.woff2`). If those files are missing, Vite's
 * SPA fallback serves index.html for /fonts/... and the browser reports
 * "Failed to decode downloaded font" / OTS invalid sfntVersion.
 */
const fs = require('fs')
const path = require('path')

const frontendRoot = path.join(__dirname, '..')
const laravelPublic = path.join(frontendRoot, '..', 'public')

function copyRecursive(src, dest) {
  if (!fs.existsSync(src)) {
    console.warn('Skip (missing):', src)
    return
  }
  fs.mkdirSync(dest, { recursive: true })
  for (const name of fs.readdirSync(src)) {
    const s = path.join(src, name)
    const d = path.join(dest, name)
    const st = fs.statSync(s)
    if (st.isDirectory()) copyRecursive(s, d)
    else fs.copyFileSync(s, d)
  }
}

/**
 * Fill in webpack-hashed MDI filenames only when missing.
 * Laravel often already has the correct hashed files (e.g. `*.d0066537.woff2` ~283KB).
 * The unhashed `materialdesignicons-webfont.woff2` can be a tiny stub (~27KB); copying it
 * over the hashed name breaks fonts and triggers "Failed to decode" / invalid sfntVersion.
 */
function linkMaterialDesignIconsAliases(fontsDir) {
  const pairs = [
    ['materialdesignicons-webfont.eot', 'materialdesignicons-webfont.2d0a0d8f.eot'],
    ['materialdesignicons-webfont.woff2', 'materialdesignicons-webfont.d0066537.woff2'],
    ['materialdesignicons-webfont.woff', 'materialdesignicons-webfont.b4917be2.woff'],
    ['materialdesignicons-webfont.ttf', 'materialdesignicons-webfont.f5111234.ttf'],
  ]
  for (const [from, to] of pairs) {
    const src = path.join(fontsDir, from)
    const dest = path.join(fontsDir, to)
    if (fs.existsSync(dest)) continue
    if (!fs.existsSync(src)) {
      console.warn('MDI alias missing source:', src)
      continue
    }
    fs.copyFileSync(src, dest)
  }
}

for (const sub of ['css', 'static', 'fonts']) {
  copyRecursive(path.join(laravelPublic, sub), path.join(frontendRoot, 'public', sub))
}

linkMaterialDesignIconsAliases(path.join(frontendRoot, 'public', 'fonts'))

console.log('Copied public/css, public/static, public/fonts (+ MDI hashed aliases) from Laravel into frontend/public/')

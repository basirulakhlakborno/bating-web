import { defineConfig, loadEnv } from 'vite'
import react from '@vitejs/plugin-react'

// Production build → `../public/dist` (Laravel `SpaController`). Use `base: '/dist/'` so assets resolve on the same host.
// Env: `.env.development` → `VITE_API_BASE_URL` (Laravel origin); `.env.production` → empty = same-origin `/`.
// https://vite.dev/config/
export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  const laravelOrigin = (env.VITE_API_BASE_URL || 'http://localhost').replace(/\/$/, '')

  return {
    base: mode === 'production' ? '/dist/' : '/',
    build: {
      outDir: '../public/dist',
      emptyOutDir: true,
      manifest: true,
    },
    server: {
      proxy: {
        // Laravel token-bridge document for the in-SPA iframe (React stays on :5173).
        '/games/iframe-shell': {
          target: laravelOrigin,
          changeOrigin: true,
        },
      },
    },
    plugins: [
      react(),
      {
        name: 'spa-fallback',
        configureServer(server) {
          server.middlewares.use((req, _res, next) => {
            const raw = req.url?.split('?')[0] ?? ''
            if (req.method !== 'GET') return next()
            if (raw.startsWith('/@') || raw.startsWith('/node_modules') || raw.startsWith('/src/')) return next()
            if (raw.includes('.')) return next()
            if (raw === '/games/iframe-shell' || raw.startsWith('/games/iframe-shell/')) return next()
            req.url = '/index.html'
            next()
          })
        },
      },
    ],
  }
})

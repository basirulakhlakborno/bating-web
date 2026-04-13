import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// Production build → `../public/dist` (Laravel `SpaController`). Use `base: '/dist/'` so assets resolve on the same host.
// Env: `.env.development` → `VITE_API_BASE_URL` (Laravel origin); `.env.production` → empty = same-origin `/`.
// https://vite.dev/config/
export default defineConfig(({ mode }) => ({
  base: mode === 'production' ? '/dist/' : '/',
  build: {
    outDir: '../public/dist',
    emptyOutDir: true,
    manifest: true,
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
          req.url = '/index.html'
          next()
        })
      },
    },
  ],
}))

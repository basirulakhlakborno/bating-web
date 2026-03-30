import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// Env: `.env.development` → `VITE_API_BASE_URL` (Laravel origin); `.env.production` → empty = same-origin `/`.
// https://vite.dev/config/
export default defineConfig({
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
})

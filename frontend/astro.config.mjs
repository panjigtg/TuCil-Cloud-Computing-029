// @ts-check
import { defineConfig } from 'astro/config';

import tailwindcss from '@tailwindcss/vite';

// https://astro.build/config
export default defineConfig({
  vite: {
    plugins: [tailwindcss()],
    server: {
      watch: {
        usePolling: false,
      },
      hmr: true,
    },
    optimizeDeps: {
      // Prevent pre-bundling to allow faster rebuilds
      include: [],
    },
  }
});
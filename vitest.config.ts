import path from 'path'
import { defineConfig } from 'vite'
import Vue from '@vitejs/plugin-vue'

export default defineConfig({
  resolve: {
    alias: {
      '~/': `${path.resolve(__dirname, 'client')}/`,
    },
  },
  plugins: [
    Vue({
      include: [/\.vue$/],
      reactivityTransform: true,
    }),
  ],
  test: {
    globals: true,
    environment: 'jsdom',
    include: [
      './tests/js/**/*.{test,spec}.{js,mjs,cjs,ts,mts,cts,jsx,tsx}',
    ],
  },
})

// https://nuxt.com/docs/api/configuration/nuxt-config

import tailwindcss from "@tailwindcss/vite";
export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  css: ['./app/assets/css/main.css'],
  runtimeConfig:{
    public:{
      baseURL: process.env.NUXT_PUBLIC_BASE_URL || 'http://localhost:8000',
    }
  },

  vite: {
    plugins: [
      tailwindcss(),
    ],
  },

  modules: ["@pinia/nuxt"],
});
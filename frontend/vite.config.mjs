// Plugins
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import Icons from 'unplugin-icons/vite'
import IconsResolver from 'unplugin-icons/resolver'
import Unfonts from 'unplugin-fonts/vite'
import Vue from '@vitejs/plugin-vue'
import Vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'

// Utilities
import { defineConfig } from 'vite'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [
    Vue({
      template: {
        transformAssetUrls
        // compilerOptions: {
        //   //treat all tags with a dash as custom elements
        //   isCustomElement: (tag) => tag.startsWith("notifications"),
        // },
      }
    }),
    Vuetify({
      autoImport: true,
      styles: {
        configFile: 'src/styles/settings.scss'
      }
    }),
    Components({
      resolvers: [
        IconsResolver({
          prefix: 'icon'
        })
      ],
      dts: false
    }),
    Unfonts({
      fontsource: {
        families: [
          {
            name: 'Montserrat Variable',
            variable: {
              wght: true
            },
            subset: 'latin'
          }
        ],
        display: 'auto',
        preload: true
      }
    }),
    AutoImport({
      imports: ['vue', 'vue-router'],
      dirs: ['src/composables/*', 'src/services/*', 'src/stores/*'],
      resolvers: [
        IconsResolver({
          prefix: 'icon'
        })
      ],
      eslintrc: {
        enabled: true
      },
      vueTemplate: true,
      dts: false
    }),
    Icons()
  ],
  define: { 'process.env': {} },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
    extensions: ['.js', '.json', '.jsx', '.mjs', '.ts', '.tsx', '.vue']
  },
  server: {
    host: '0.0.0.0',
    port: 3090,
    watch: {
      usePolling: true
    }
  },
  test: {
    globals: true,
    environment: 'jsdom',
    server: {
      deps: {
        inline: ['vuetify']
      }
    }
  }
})

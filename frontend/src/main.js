// Plugins
import { registerPlugins } from '@/plugins'
import { registerDirectives } from '@/directives'

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'

const app = createApp(App)

app.config.errorHandler = (err, instance, info) => {
  console.error('Error handler', err)
  console.error('Instance', instance)
  console.error('Info', info)
  // Handle specific error
  if (err.message.includes('Failed to fetch dinamically imported module')) {
    console.warn('Failed dynamic import, reloading...')
    window.location.reload()
  }
}

registerPlugins(app)
registerDirectives(app)

app.mount('#app')

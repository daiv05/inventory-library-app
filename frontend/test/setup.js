// Configuración necesaria para los test con Vuetify
import { vi } from 'vitest'

// Mock de ResizeObserver que requiere Vuetify
global.ResizeObserver = vi.fn().mockImplementation(() => ({
  observe: vi.fn(),
  unobserve: vi.fn(),
  disconnect: vi.fn()
}))

// Configurar el elemento raíz para Vuetify
document.body.setAttribute('data-app', true)

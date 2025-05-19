import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import AppStatusChip from '../AppStatusChip.vue'

describe('AppStatusChip', () => {
  const vuetify = createVuetify({
    components,
    directives
  })

  it('renderiza el chip con el estado activo correctamente', () => {
    const wrapper = mount(AppStatusChip, {
      props: {
        status: '1'
      },
      global: {
        plugins: [vuetify]
      }
    })

    // Verificar que el chip existe
    const chip = wrapper.findComponent({ name: 'VChip' })
    expect(chip.exists()).toBe(true)

    // Verificar que el color es el correcto para estado activo
    expect(chip.props('color')).toBe('green')

    // Verificar el texto del chip
    expect(chip.text()).toBe('Activo')
  })

  it('renderiza el chip con el estado inactivo correctamente', () => {
    const wrapper = mount(AppStatusChip, {
      props: {
        status: '2'
      },
      global: {
        plugins: [vuetify]
      }
    })

    const chip = wrapper.findComponent({ name: 'VChip' })
    expect(chip.exists()).toBe(true)
    expect(chip.props('color')).toBe('red')
    expect(chip.text()).toBe('Inactivo')
  })

  it('acepta el status tanto como string como número', () => {
    // Test con string
    const wrapperString = mount(AppStatusChip, {
      props: {
        status: '1'
      },
      global: {
        plugins: [vuetify]
      }
    })
    expect(wrapperString.findComponent({ name: 'VChip' }).exists()).toBe(true)

    // Test con número
    const wrapperNumber = mount(AppStatusChip, {
      props: {
        status: 1
      },
      global: {
        plugins: [vuetify]
      }
    })
    expect(wrapperNumber.findComponent({ name: 'VChip' }).exists()).toBe(true)
  })
})

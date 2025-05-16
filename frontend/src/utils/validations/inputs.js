export const required = (value, messagge) => {
  messagge = messagge || 'Este campo es requerido.'
  if (value) return true
  else return messagge
}

export const email = (value, messagge) => {
  messagge = messagge || 'Debe ingresar un e-mail valido.'
  const regEmail = /^([a-zA-Z0-9._+-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z0-9]+)+$/
  if (value) {
    if (regEmail.test(value)) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const customEmail = (value, message, custom) => {
  message = message || 'Debe ingresar un e-mail válido.'
  custom = custom || ''

  const regEmail = /^([a-zA-Z0-9._+-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z0-9]+)+$/

  if (value) {
    if (regEmail.test(value)) {
      if (custom && value.includes(custom)) {
        return true
      } else {
        return message
      }
    } else {
      return message
    }
  } else {
    return true
  }
}

export const minlength = (value, messagge, length) => {
  messagge = messagge || `Debe ingresar al menos ${length} caracteres.`
  if (value) {
    if (value.length > length) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const maxlength = (value, messagge, length) => {
  messagge = messagge || `Debe ingresar menos de ${length} caracteres.`
  if (value) {
    if (value.length < length) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const textfield = (value, messagge) => {
  messagge = messagge || 'Debe ingresar solo letras.'
  const regText = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 -]*$/
  if (value) {
    if (regText.test(value)) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const textarea = (value, messagge) => {
  messagge = messagge || 'Debe ingresar solo letras.'
  const regText = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ()/.,\n:;-]*$/
  if (value) {
    if (regText.test(value)) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const url = (value, messagge) => {
  messagge = messagge || 'Debe ingresar una url valida.'
  const regUrl =
    /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/

  if (value) {
    if (regUrl.test(value)) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const number = (value, messagge) => {
  messagge = messagge || 'Debe ingresar solo numeros.'
  const regNumber = /^[0-9]*$/
  if (value) {
    if (regNumber.test(value)) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const phone = (value, messagge) => {
  messagge = messagge || 'Debe ingresar un teléfono valido(####-####)'

  const regPhone = /^\(?([0-9]{4})\)?-+?([0-9]{4})$/
  if (value) {
    if (value.charAt(0) == '2' || value.charAt(0) == '6' || value.charAt(0) == '7') {
      if (regPhone.test(value)) {
        return true
      } else {
        return messagge
      }
    } else {
      return "El teléfono debe iniciar con un '2, 6 o 7'"
    }
  } else {
    return true
  }
}

export const requiredIf = (value, messagge, condition) => {
  messagge = messagge || 'Este campo es requerido.'
  if (condition) {
    if (value) return true
    else return messagge
  } else {
    return true
  }
}

export const regex = (value, messagge, regex) => {
  messagge = messagge || 'Debe ingresar un formato valido.'
  if (value) {
    if (regex.test(value)) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const equal = (value, messagge, equal) => {
  messagge = messagge || 'Los campos no coinciden.'
  if (value) {
    if (value === equal) {
      return true
    } else {
      return messagge
    }
  } else {
    return true
  }
}

export const isPdf = (value, messagge, size) => {
  messagge = messagge || 'Debe ingresar un archivo PDF.'
  size = size || 10000000
  value = value[0]
  const regAlfaNumPdf = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\-_\s]+(?=\.pdf$)/

  if (value) {
    if (value.type === 'application/pdf') {
      if (value.size <= size) {
        if (regAlfaNumPdf.test(value.name)) {
          return true
        } else {
          return 'El nombre del archivo no debe contener caracteres especiales.'
        }
      } else {
        return 'El archivo no debe pesar mas de 10MB.'
      }
    } else {
      return messagge
    }
  } else {
    return true
  }
}

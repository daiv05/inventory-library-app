import dayjs from 'dayjs'
import 'dayjs/locale/es'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter'
import isBetween from 'dayjs/plugin/isBetween'
import timezone from 'dayjs/plugin/timezone'

// Global configuration
dayjs.extend(timezone)
dayjs.locale('es')
dayjs.tz.setDefault('America/El_Salvador')

/**
 * Función para convertir una fecha/hora a un formato específico
 * @param {(string|Date)} value - Fecha a convertir
 * @param {string} formatOutput - Formato de salida
 * @returns {?string} Fecha convertida al formato especificado
 */
const FormatDate = (value, formatOutput = 'DD/MM/YYYY') => {
  if (value) {
    return dayjs(value).format(formatOutput)
  } else return null
}

/**
 * Función para convertir una fecha/hora a formato ISO8601 (YYYY-MM-DD / YYYY-MM-DDTHH:mm:ss)
 * @param {(string|Date)} value - Fecha a convertir
 * @param {string} formatString - Formato de salida
 * @returns {?string} Fecha convertida al formato especificado
 */
const FormatDateToISO = (value, formatString = 'DD/MM/YYYY', withTime = false) => {
  if (value) {
    const format = withTime ? 'YYYY-MM-DDTHH:mm:ss' : 'YYYY-MM-DD'
    return dayjs(value, formatString).format(format)
  } else return null
}

/**
 * Función para convertir una fecha/hora (segun el formato) a un objeto Date
 * @param {string} value - Fecha/hora a convertir
 * @param {string} formatString - Formato de la fecha a convertir
 * @returns {?Date} Objeto Date con la fecha convertida
 */
const CreateDateFromFormat = (value, formatString = 'DD/MM/YYYY') => {
  if (value) {
    dayjs.extend(customParseFormat)
    return dayjs(value, formatString).toDate()
  } else return null
}

/**
 * Función para verificar si una fecha/hora es mayor a otra
 * @param {string} firstDate - Fecha a comparar
 * @param {string} secondDate - Fecha de referencia
 * @param {string} formatString - Formato de las fechas
 * @param {string} level - Nivel de comparación
 * @returns {?boolean} Booleano con el resultado de la comparación
 */
const IsDateAfter = (firstDate, secondDate, formatString = 'DD/MM/YYYY', level = 'day') => {
  if (firstDate && secondDate) {
    dayjs.extend(customParseFormat)
    return dayjs(firstDate, formatString).isAfter(dayjs(secondDate, formatString), level)
  } else return null
}

/**
 * Función para verificar si una fecha/hora es igual a otra
 * @param {string} firstDate - Fecha a comparar
 * @param {string} secondDate - Fecha de referencia
 * @param {string} formatString - Formato de las fechas
 * @param {string} level - Nivel de comparación
 * @returns {?boolean} Booleano con el resultado de la comparación
 */
const IsDateSame = (firstDate, secondDate, formatString = 'DD/MM/YYYY', level = 'day') => {
  if (firstDate && secondDate) {
    dayjs.extend(customParseFormat)
    return dayjs(firstDate, formatString).isSame(dayjs(secondDate, formatString), level)
  } else return null
}

/**
 * Verificar si una fecha/hora es igual o mayor a otra
 * @param {string} firstDate - Fecha a comparar
 * @param {string} secondDate - Fecha de referencia
 * @param {string} formatString - Formato de las fechas
 * @param {string} level - Nivel de comparación
 * @returns {?boolean} Booleano con el resultado de la comparación
 */
const IsDateSameOrAfter = (
  firstDate,
  secondDate,
  formatString = 'DD/MM/YYYY',
  level = 'second'
) => {
  if (firstDate && secondDate) {
    dayjs.extend(customParseFormat)
    dayjs.extend(isSameOrAfter)
    return dayjs(firstDate, formatString).isSameOrAfter(dayjs(secondDate, formatString), level)
  } else return null
}

/**
 * Verificar si una fecha/hora está dentro del rango indicado
 * @param {string} mainDate - Fecha a comparar
 * @param {string} initialDate - Fecha inicial del rango
 * @param {string} finalDate - Fecha final del rango
 * @param {string} formatString - Formato de las fechas
 * @param {string} level - Nivel de comparación
 * @param {string} inclusivity - Tipo de inclusividad ('[]', '[)', '(]', '()')
 * @returns {?boolean} Booleano con el resultado de la comparación
 */
const IsDateBetween = (
  mainDate,
  initialDate,
  finalDate,
  formatString = 'DD/MM/YYYY',
  level = null,
  inclusivity = '[]' // Se incluyen las fechas de inicio y fin
) => {
  if (mainDate && initialDate && finalDate) {
    dayjs.extend(customParseFormat)
    dayjs.extend(isBetween)
    return dayjs(initialDate, formatString).isBetween(
      dayjs(finalDate, formatString),
      level,
      inclusivity
    )
  } else return null
}

export {
  FormatDate,
  FormatDateToISO,
  CreateDateFromFormat,
  IsDateAfter,
  IsDateSame,
  IsDateSameOrAfter,
  IsDateBetween
}

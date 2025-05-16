const alphaNumeric = /^[a-zA-Z0-9]*$/
const alpha = /^[a-zA-Z]*$/
const numeric = /^[0-9]*$/
const email = /^([a-zA-Z0-9._+-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z0-9]+)+$/
const url = /^(http|https):\/\/[^ "]+$/
const phone = /^[0-9]{10,10}$/
const password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
const text = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 -]*$/
const textarea = /^[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ()/.,\n:;-]*$/
const number = /^[0-9]*$/
const decimal = /^[0-9]+(\.[0-9]+)?$/
const positive = /^[0-9]*$/
const negative = /^-[0-9]*$/
const integer = /^[+-]?[0-9]+$/
const float = /^[+-]?([0-9]*[.])?[0-9]+$/
const hex = /^#?([a-f0-9]{6}|[a-f0-9]{3})$/
const rgb = /^rgb\((\d{1,3}), (\d{1,3}), (\d{1,3})\)$/
const rgba = /^rgba\((\d{1,3}), (\d{1,3}), (\d{1,3}), (0(\.\d+)?|1(\.0+)?)\)$/
const hsl = /^hsl\((\d{1,3}), (\d{1,3})%, (\d{1,3})%\)$/
const hsla = /^hsla\((\d{1,3}), (\d{1,3})%, (\d{1,3})%, (0(\.\d+)?|1(\.0+)?)\)$/
const date = /^\d{4}-\d{2}-\d{2}$/
const time = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/
const datetimeutc = /^\d{4}-\d{2}-\d{2}T([01]?[0-9]|2[0-3]):[0-5][0-9]$/
const datetimelocalutc = /^\d{4}-\d{2}-\d{2}T([01]?[0-9]|2[0-3]):[0-5][0-9]$/

export {
  alphaNumeric,
  alpha,
  numeric,
  email,
  url,
  phone,
  password,
  text,
  textarea,
  number,
  decimal,
  positive,
  negative,
  integer,
  float,
  hex,
  rgb,
  rgba,
  hsl,
  hsla,
  date,
  time,
  datetimeutc,
  datetimelocalutc
}

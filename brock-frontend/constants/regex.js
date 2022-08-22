export const CURRENCY_VALIDATION_REGEX = /^\d+(.\d{0,2})?$/

export const DATE_VALIDATION_REGEX =
  /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/

export const DATE_WITH_TIME_VALIDATION_REGEX =
  /^(0?[1-9]|1[0-2])\/(0?[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}[' '](0[0-9]|1[\d]|2[0-3]):(0[0-9]|[1-5][\d])$/

export const PHONE_VALIDATION_REGEX =
  /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/
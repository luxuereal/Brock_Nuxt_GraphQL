import { extend } from 'vee-validate'
import {
  alpha,
  between,
  double,
  email,
  numeric,
  required,
} from 'vee-validate/dist/rules'
import {
  CURRENCY_VALIDATION_REGEX,
  DATE_VALIDATION_REGEX,
  DATE_WITH_TIME_VALIDATION_REGEX,
  PHONE_VALIDATION_REGEX,
} from '~/constants/regex'

extend('currency', {
  validate: (value) => CURRENCY_VALIDATION_REGEX.test(value),
  message: 'The {_field_} must have to be digit with two digits after dot',
})

extend('required', {
  ...required,
  message: 'The {_field_} is required',
})

extend('date', {
  validate: (value) => DATE_VALIDATION_REGEX.test(value),
  message: 'The {_field_} must be in "mm/dd/yyyy" format',
})

extend('max', {
  params: ['length'],
  validate(value, args) {
    return value.length <= args.length;
  },
  message: 'The {_field_} length must be less than 255.'
});

extend('dateWithTime', {
  validate: (value) => DATE_WITH_TIME_VALIDATION_REGEX.test(value),
  message: 'The {_field_} must be in "mm/dd/yyyy hh:mm" format',
})

extend('phone', {
  validate: (value) => PHONE_VALIDATION_REGEX.test(value),
  message: 'Phone must be in (123) 456-7890 format',
})

extend('numeric', {
  ...numeric,
  message: 'The {_field_} must be numeric',
}) 

extend('double', {
  ...double,
  message: 'The {_field_} should not contain letters',
})

extend('email', {
  ...email,
  message: 'Email is not valid',
})

extend('between', {
  ...between,
  message: 'This {_field_} value must be between {min} and {max}',
})

extend('password', {
  params: ['target'],
  validate(value, { target }) {
    return value === target
  },
  message: 'Confirm password does not match',
})

extend('alpha', {
  ...alpha,
  message: 'The {_field_} should be alphabetic',
})

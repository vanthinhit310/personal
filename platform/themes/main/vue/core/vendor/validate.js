import Vue from 'vue'
import { ValidationProvider, extend, ValidationObserver } from 'vee-validate'
import { required, email, numeric, min, max, max_value, min_value } from 'vee-validate/dist/rules'

extend('password', {
    params: ['target'],
    validate(value, { target }) {
      return value === target;
    },
    message: 'Xác nhận mật khẩu chưa chính xác'
  });

extend('required', {
    ...required,
    message: 'Trường thông tin này là bắt buộc'
})

extend('email', {
    ...email,
    message: 'Email sai định dạng'
})

extend('numeric', {
    ...numeric,
    message: 'Trường thông tin này phải là một số'
})

extend('min', {
    ...min,
    params:  ['length'],
    message: 'Trường thông tin này có tối thiểu {length} ký tự'
})

extend('max', {
    ...max,
    params:  ['length'],
    message: 'Trường thông tin này có tối đa {length} ký tự'
})

extend('min_value', {
    ...min_value,
    params:  ['value'],
    message: 'Trường này phải ít hơn hoặc bằng {value} ký tự'
})

extend('max_value', {
    ...max_value,
    params:  ['value'],
    message: 'Trường này phải nhiều hơn hoặc bằng {value} ký tự'
})


Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)

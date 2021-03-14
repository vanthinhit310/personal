import Vue from "vue";
import { ValidationProvider, extend, ValidationObserver } from "vee-validate";
import {
    required,
    email,
    numeric,
    min,
    max,
    max_value,
    min_value
} from "vee-validate/dist/rules";

extend("password", {
    params: ["target"],
    validate(value, { target }) {
        return value === target;
    }
});

extend("required", {
    ...required
});

extend("email", {
    ...email
});

extend("numeric", {
    ...numeric
});

extend("min", {
    ...min,
    params: ["length"]
});

extend("max", {
    ...max,
    params: ["length"]
});

extend("min_value", {
    ...min_value,
    params: ["value"]
});

extend("max_value", {
    ...max_value,
    params: ["value"]
});

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);

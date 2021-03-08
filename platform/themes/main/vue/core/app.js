require("./bootstrap.js");
require("./vendor/global.js");
require("./vendor/import.js");
require("./vendor/validate");

import Vue from 'vue'
/* Import route and store main file */
import router from "./router/index";
import store from "./store/index";
/* Import route and store main file */

const app = new Vue({
    el: "#app",
    router,
    store,
});

export default app;

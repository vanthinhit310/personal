require("./bootstrap");

require("./vendor/import");

require("./vendor/validate");

require("./vendor/global");

import Vue from "vue";
/* Import lodash */
import _ from "lodash";
Vue.prototype._ = _;
/* Import lodash */
Vue.config.productionTip = false
/* Import route and store main file */
import router from "@core/router/index";
import store from "@core/store/index";
/* Import route and store main file */

const app = new Vue({
    el: "#app",
    router,
    store
});

export default app;

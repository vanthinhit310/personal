/* import Vue */
import Vue from "vue";
/* import Vue */

/* import Ant Design Vue */
import Antd from "ant-design-vue";
Vue.config.productionTip = false;
Vue.use(Antd);
/* import Ant Design Vue */

import ElementUI from "element-ui";
import elementLocale from "element-ui/lib/locale/lang/en";
Vue.use(ElementUI, { size: "small", zIndex: 10, locale: elementLocale });

import VueProgressBar from "vue-progressbar";

import HighchartsVue from "highcharts-vue";
import Highcharts from "highcharts";
import applyTheme from "highcharts/themes/grid";
applyTheme(Highcharts);
Vue.use(HighchartsVue);

Vue.use(VueProgressBar, {
    color: "#FF7A59",
    failedColor: "red",
    height: "3px"
});

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
import mapInit from "highcharts/modules/map";
import Exporting from "highcharts/modules/exporting";
import Lollipop from "highcharts/modules/lollipop";
import Dumbbell from "highcharts/modules/dumbbell";
import highchartsMore from "highcharts/highcharts-more";
import Accessibility from "highcharts/modules/accessibility";
import mapData from "@highcharts/map-collection/custom/world.geo.json";
import applyTheme from "highcharts/themes/grid-light";
Exporting(Highcharts);
highchartsMore(Highcharts);
Dumbbell(Highcharts);
Lollipop(Highcharts);
Accessibility(Highcharts);
mapInit(Highcharts);
applyTheme(Highcharts);
Highcharts.maps["custom/world"] = mapData;
Vue.use(HighchartsVue);

Vue.use(VueProgressBar, {
    color: "#FF7A59",
    failedColor: "red",
    height: "3px"
});

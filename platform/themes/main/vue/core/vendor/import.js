/* import Vue */
import Vue from 'vue';
/* import Vue */

/* import Ant Design Vue */
import Antd from 'ant-design-vue';
Vue.config.productionTip = false;
Vue.use(Antd);
/* import Ant Design Vue */

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#FF7A59',
    failedColor: 'red',
    height: '4px'
})

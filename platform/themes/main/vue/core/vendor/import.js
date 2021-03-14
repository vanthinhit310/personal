/* import Vue */
import Vue from 'vue';
/* import Vue */

/* import Ant Design Vue */
import Antd from 'ant-design-vue';
Vue.config.productionTip = false;
Vue.use(Antd);
/* import Ant Design Vue */

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI, { size: 'default', zIndex: 15 });


import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#FF7A59',
    failedColor: 'red',
    height: '4px'
})

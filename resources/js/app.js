
require('./bootstrap');
window.Vue = require('vue').default;

import VueRoute from 'vue-router';
import routes from './routes';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en'
import vuetify from './vuetify';

Vue.use(VueRoute);
Vue.use(ElementUI, { locale })


Vue.component('main-page',require('./components/Main.vue').default);
Vue.component('test-page',require('./components/Test.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router: new VueRoute(routes),
    
});
// https://www.devopinion.com/friendship-system-for-social-site-in-laravel/

require('./bootstrap');
import Vue from 'vue'
import moment from 'moment'
import './components/plugins/chart'
import router from './router'
import universal from './universal'
import store from './store'
window.Vue = require('vue');
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import locale from 'view-design/dist/locale/en-US';
Vue.use(ViewUI, {locale: locale});
// loading
router.beforeEach((to, from, next) => {
    ViewUI.LoadingBar.start();
    next();
});

router.afterEach(route => {
    ViewUI.LoadingBar.finish();
});

Vue.mixin(universal);
Vue.prototype.moment = moment


// import App from './components/app.vue'
Vue.component('app', require('./components/app.vue').default);
const app = new Vue({
    el: '#app',
    router,
    store

});
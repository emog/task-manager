require('./bootstrap');
import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

// Import Vue App, routes, store, filters
import App from './App';
import store from './store';
import router from "./router";
// import './filters';
import './plugins'
import NProgress from 'vue-nprogress'

Vue.use(NProgress, {
    latencyThreshold: 200, // Number of ms before progressbar starts showing, default: 100,
    router: true, // Show progressbar when navigating routes, default: true
    http: false // Show progressbar when doing Vue.http, default: true
});

const nprogress = new NProgress();

Vue.config.productionTip = false;

new Vue({
    el: '#app',
    render: h => h(App),
    nprogress,
    router,
    store
});

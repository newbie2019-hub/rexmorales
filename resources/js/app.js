require('./bootstrap');

window.Vue = require('vue');

import scripts from './scripts/scripts.js'
import router from './scripts/router.js'
import store from './scripts/store'

//VUE TOAST 
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

Vue.use(Toast, {
    transition: "Vue-Toastification__fade",
    maxToasts: 5,
    newestOnTop: true
});

Vue.mixin(scripts)
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('main-component', require('./views/App.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});

import axios from 'axios';
import Base from './base';
import moment from 'moment-timezone';
import Routes from './routes';
import Vue from 'vue';
import VueJsonPretty from 'vue-json-pretty';
import VueRouter from 'vue-router';

require('bootstrap');

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.use(VueRouter);

moment.tz.setDefault(App.timezone);

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: '/vapor-ui',
});

Vue.component('vue-json-pretty', VueJsonPretty);
Vue.component('log-list-screen', require('./components/LogListScreen.vue').default);
Vue.component('log-preview-screen', require('./components/LogPreviewScreen.vue').default);

Vue.mixin(Base);

new Vue({
    el: '#vapor-ui',
    router,
});

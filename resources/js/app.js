import axios from 'axios';
import Base from './base';
import moment from 'moment-timezone';
import Routes from './routes';
import Vue from 'vue';
import VueJsonPretty from 'vue-json-pretty';
import VueRouter from 'vue-router';

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

router.beforeEach((to, from, next) => {
    to.meta.title = to.meta.createTitle(to.params);

    document.title = 'Vapor UI - ' + to.meta.title;

    next();
});

Vue.component('vue-json-pretty', VueJsonPretty);

// Components
Vue.component('async-button', require('./components/AsyncButton.vue').default);
Vue.component('bar-chart', require('./components/BarChart.vue').default);
Vue.component('search', require('./components/Search.vue').default);
Vue.component('search-details', require('./components/SearchDetails.vue').default);
Vue.component('search-empty-results', require('./components/SearchEmptyResults.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('metric', require('./components/Metric.vue').default);
Vue.component('popover', require('./components/Popover.vue').default);

// Icons
Vue.component('icon-arrow-down', require('./components/icons/ArrowDown.vue').default);
Vue.component('icon-arrow-up', require('./components/icons/ArrowUp.vue').default);
Vue.component('icon-refresh', require('./components/icons/Refresh.vue').default);
Vue.component('icon-search', require('./components/icons/Search.vue').default);
Vue.component('icon-cloud', require('./components/icons/Cloud.vue').default);
Vue.component('icon-collection', require('./components/icons/Collection.vue').default);
Vue.component('icon-exclamation', require('./components/icons/Exclamation.vue').default);
Vue.component('icon-desktop-computer', require('./components/icons/DesktopComputer.vue').default);
Vue.component('icon-dots-vertical', require('./components/icons/DotsVertical.vue').default);
Vue.component('icon-loader', require('./components/icons/Loader.vue').default);
Vue.component('icon-flag', require('./components/icons/Flag.vue').default);
Vue.component('icon-calendar', require('./components/icons/Calendar.vue').default);
Vue.component('icon-clipboard-copy', require('./components/icons/ClipboardCopy.vue').default);
Vue.component('icon-chevron-right', require('./components/icons/ChevronRight.vue').default);
Vue.component('icon-eye', require('./components/icons/Eye.vue').default);
Vue.component('icon-chart-bar', require('./components/icons/ChartBar.vue').default);
Vue.component('icon-terminal', require('./components/icons/Terminal.vue').default);
Vue.component('icon-x-circle', require('./components/icons/XCircle.vue').default);
Vue.component('icon-information-circle', require('./components/icons/InformationCircle.vue').default);

Vue.mixin(Base);

new Vue({
    el: '#vapor-ui',
    router,
});

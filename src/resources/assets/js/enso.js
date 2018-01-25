import Vue from 'vue';
import axios from 'axios';
import lodash from 'lodash';
import moment from 'moment';
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';

import './modules/enso/';

import router from './router';
import store from './store';
import App from './pages/App.vue';
import Toastr from './components/enso/bulma/toastr';

import './app';

Vue.component('fa', FontAwesomeIcon);

Vue.use(Toastr, {
    i18n: store.getters['locale/__'],
    position: 'right',
    duration: 3000,
    closeButton: true,
});

const bus = new Vue({ name: 'Bus' });
Vue.prototype.$bus = bus;

window._ = lodash;
window.moment = moment;
window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

new Vue({
    router,
    store,
    ...App,
}).$mount('#app');

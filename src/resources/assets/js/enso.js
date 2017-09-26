require('./bootstrap');
require('./app');

import App from './components/enso/App.vue';

new Vue({
    el: '#app',
    components: { App }
});
window.$ = window.jQuery = require('jquery');
require('datatables.net');
require('datatables.net-select');
require('datatables.net-colreorder');
require('datatables.net-responsive');
require('datatables.net-buttons');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.html5.js');

import Vue from 'vue';
window.Vue = Vue;

const bus = new Vue({ name: 'Bus' });
Vue.prototype.$bus = bus;

import VTooltip from 'vue-directive-tooltip';
Vue.use(VTooltip);

require('at.js');
require('jquery.caret');
require('at.js/dist/css/jquery.atwho.min.css');

window._ = require('lodash');
window.moment = require('moment');
window.toastr = require('toastr');
require('toastr/build/toastr.min.css');

window.axios = require('axios');
require('./modules/enso/plugins/axios');

require('./modules/enso/plugins/route');
require('./modules/enso/filters');
require('./modules/enso/directives');
require('./modules/enso/prototypes');
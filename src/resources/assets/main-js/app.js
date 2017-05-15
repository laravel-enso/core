/* START core START */
require('./polyfill');
require('./bootstrap');

window.initBootstrapSelect = require('./vendor/laravel-enso/modules/initBootstrapSelect');

Vue.component('notifications', require('./vendor/laravel-enso/components/Notifications.vue'));
Vue.component('sidebar', require('./vendor/laravel-enso/components/Sidebar.vue'));
Vue.component('typeahead', require('./vendor/laravel-enso/components/Typeahead.vue'));
Vue.component('inputClear', require('./vendor/laravel-enso/components/InputClear.vue'));
Vue.component('datepicker', require('./vendor/laravel-enso/components/Datepicker.vue'));
Vue.component('timepicker', require('./vendor/laravel-enso/components/Timepicker.vue'));
Vue.component('modal', require('./vendor/laravel-enso/components/Modal.vue'));
Vue.component('vueFilter', require('./vendor/laravel-enso/components/VueFilter.vue'));
Vue.component('chart', require('./vendor/laravel-enso/components/Chart.vue'));
Vue.component('dataTable', require('./vendor/laravel-enso/components/DataTable.vue'));
Vue.component('vueSelect', require('./vendor/laravel-enso/components/VueSelect.vue'));
Vue.component('checkboxManager', require('./vendor/laravel-enso/components/CheckboxManager.vue'));
Vue.component('roleConfigurator', require('./vendor/laravel-enso/components/RoleConfigurator.vue'));
Vue.component('dashboard', require('./vendor/laravel-enso/components/Dashboard.vue'));
Vue.component('reorderableMenu', require('./vendor/laravel-enso/components/ReorderableMenu.vue'));
Vue.component('fileUploader', require('./vendor/laravel-enso/components/FileUploader.vue'));

Vue.component('draggable', require('vuedraggable'));

/* END core END */
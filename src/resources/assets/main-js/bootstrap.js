window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

import Vue from 'vue';
window.Vue = Vue;

import axios from 'axios';
window.axios = axios;

import VTooltip from 'v-tooltip';
Vue.use(VTooltip);

window.eventHub = new Vue();

require('pusher-js');
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: document.head.querySelector("[name=pusher-key]").content,
    cluster: 'eu',
    namespace: 'App.Events'
});

window.Laravel = { "csrfToken": document.head.querySelector("[name=csrf-token]").content };
window.Preferences = JSON.parse(document.head.querySelector("[name=preferences]").content);

require("babel-polyfill");

Vue.filter('numberFormat', function(value) {

    value += '';
    let x = value.split('.');
    let x1 = x[0];
    let x2 = x.length > 1 ? '.' + x[1] : '';
    let rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
});

Vue.directive('select-on-focus', {

    inserted: function (el) {

        el.addEventListener('focus',function(el){

            this.select();
        });
    }
});

Vue.directive('focus', {
    inserted: function (el) {
        el.focus();
    }
});

Array.prototype.unique = function() {
    return this.filter(function (value, index, self) {
        return self.indexOf(value) === index;
    });
};

Array.prototype.insert = function (index, item) {
  this.splice(index, 0, item);
};

String.prototype.capitalizeFirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
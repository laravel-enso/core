import Vue from 'vue';
import store from '../../../store';

const __ = store.getters['localisation/__'];

Vue.mixin({
    methods: {
        __(key, params) {
            if (!store.getters['localisation/isInitialised']) {
                return key;
            }

            return __(key, params);
        },
    },
});

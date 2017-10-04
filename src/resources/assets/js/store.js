import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import router from './router';

import { locale } from './store/enso/locale';
import { menus } from './store/enso/menus';
import { layout } from './store/enso/layout';
import { auth } from './store/enso/auth';

const store = new Vuex.Store({
	strict: true,

    modules: { locale, menus, layout, auth },

    state: {
        user: {},
        impersonating: null,
        meta: {},
        stateLoaded: false
    },

    getters: {
        avatarLink: (state, getters) => route('core.avatars.show', (state.user.avatarId || 'null'), false).toString()
    },

    mutations: {
        setUser: (state, user) => state.user = user,
        setImpersonating: (state, impersonating) => state.impersonating = impersonating,
        setUserAvatar: (state, avatarId) => state.user.avatarId = avatarId,
        setTheme: (state, theme) => state.user.preferences.global.theme = theme,
        setLocale: (state, locale) => state.user.preferences.global.lang = locale,
        setMeta: (state, meta) => state.meta = meta,
        setStateLoaded: (state) => state.stateLoaded = true
    },

    actions: {
        setState({ commit, dispatch }) {
            axios.get(route('init', [], false)).then(({data}) => {
                commit('setUser', data.user);
                commit('setImpersonating', data.impersonating);
                commit('menus/set', data.menus);
                commit('menus/setImplicit', data.implicitMenu);
                router.addRoutes([{ name: 'home', path:'/', redirect: { name: data.implicitMenu.link } }])
                commit('locale/setLanguages', data.languages);
                commit('locale/setI18n', data.i18n);
                dispatch('locale/setLocale', data.user.preferences.global.lang);
                commit('layout/setThemes', data.themes);
                commit('setMeta', data.meta);
                commit('setStateLoaded');
                dispatch('layout/setTheme');
            });
        }
    }
});

export default store;
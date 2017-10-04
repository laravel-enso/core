import Cookie from 'js-cookie';
import router from '../../router';

export const auth = {
	namespaced: true,

    state: {
        jwt: Cookie.get('jwtToken'),
        pusher: Cookie.get('pusherToken')
    },

    mutations: {
        setPusher: (state, token) => state.pusher = token,
        setJwt: (state, token) => state.jwt = token,
    },

    getters: {
        isAuth: (state, getters) => typeof state.jwt === 'string'
    },

    actions: {
        login({ commit }, { tokens, remember } ) {
            commit('setJwt', tokens.jwt);
            Cookie.set('jwtToken', tokens.jwt, { expires: remember ? 30 : null });
            commit('setPusher', tokens.pusher);
            Cookie.set('pusherToken', tokens.pusher, { expires: remember ? 30 : null });
        },
        logout({ commit }) {
            commit('setJwt', null);
            Cookie.remove('jwtToken');
            commit('setPusher', null);
            Cookie.remove('pusherToken');
            commit('setMeta', {}, {root:true});
            router.replace({ name: 'login' });
        }
    }
};
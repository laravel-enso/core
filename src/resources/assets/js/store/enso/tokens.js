import Cookie from 'js-cookie';

export const tokens = {
	namespaced: true,

    state: {
        auth: Cookie.get('auth'),
        pusher: Cookie.get('pusherToken')
    },

    mutations: {
        setPusher: (state, token) => state.pusher = token,
        setAuth: (state, token) => state.auth = token,
    },

    actions: {
        set({ commit }, { tokens, remember } ) {
            // axios.interceptors.request.use(request => {
            //     request.headers.common['Authorization'] = `Bearer ${tokens.auth}`;

            //     return request;
            // });

            commit('setAuth', true);
            Cookie.set('auth', true, { expires: remember ? tokens.expires_in : null });
            commit('setPusher', tokens.pusher);
            Cookie.set('pusherToken', tokens.pusher, { expires: remember ? tokens.expires_in : null });
        },
    }
};
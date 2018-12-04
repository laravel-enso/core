export const state = {
    i18n: {},
    languages: [],
    keyCollector: false,
};

export const getters = {
    isInitialised: state => Object.keys(state.i18n).length > 0,
    __: (state, getters, rootState, rootGetters) => (key, params) => {
        const lang = rootGetters['preferences/lang']
            || ((rootState.preferences && rootState.preferences.global)
                ? rootState.preferences.global.lang : null);

        let translation = state.i18n[lang]
            ? state.i18n[lang][key]
            : key;

        if (typeof translation === 'undefined'
            && rootState.localisation.keyCollector) {
                store.dispatch('localisation/addMissingKey', key);
        }

        translation = translation || key;
        if(params) {
            translation = translation.replace(/:(\w*)/g, function(e, key) {
                let param = params[key.toLowerCase()];
                if(key === key.toUpperCase()) // param is uppercased
                    param = param.toUpperCase();
                else if(key[0] === key[0].toUpperCase()) // first letter is uppercased
                    param = param.charAt(0).toUpperCase() + param.slice(1);
                return param;
            });
        }
        return translation;
    },
    documentTitle: (state, getters, rootState) =>
        title => (rootState.meta.extendedDocumentTitle
            ? `${getters.__(title)} | ${rootState.meta.appName}`
            : getters.__(title)),
};

export const mutations = {
    setI18n: (state, i18n) => (state.i18n = i18n),
    setLanguages: (state, languages) => (state.languages = languages),
    addKey: (state, key) => {
        Object.keys(state.i18n).forEach((lang) => {
            state.i18n[lang][key] = '';
        });
    },
    setKeyCollector: (state, status) => (state.keyCollector = status),
};

export const actions = {
    addMissingKey({ commit }, key) {
        axios.patch(route('system.localisation.addKey'), { langKey: key });
        commit('addKey', key);
    },
};

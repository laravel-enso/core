export const state = {
    i18n: {},
    languages: [],
};

export const mutations = {
    setI18n: (state, i18n) => { state.i18n = i18n; },
    setLanguages: (state, languages) => { state.languages = languages; },
};

export const getters = {
    __: (state, getters, rootState) => (key) => {
        if (!rootState.user.preferences) {
            return key;
        }

        const { lang } = rootState.user.preferences.global;
        const { env } = rootState.meta;
        if (state.i18n[lang] && state.i18n[lang][key] !== undefined) {
            return (state.i18n[lang][key] || key);
        } else {
            if (env === 'local') { 
                axios.patch("/api/system/localisation/addLangKey", { langKey: key }).then((response) => {
                    // not needed
                }).catch((error) => {
                    // not needed
                });
            }
            return key;
        }
    },
    current: (state, getters, rootState) => (rootState.user.preferences ?
        rootState.user.preferences.global.lang
        : null),
};

export const actions = {
    setLocale({ commit }, selectedLocale) {
        commit('setLocale', selectedLocale, { root: true });
    },
};

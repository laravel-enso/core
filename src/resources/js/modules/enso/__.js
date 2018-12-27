import store from '../../store';

const __ = store.getters[ 'localisation/__' ];

export default function (key, params) {
    if (!store.getters[ 'localisation/isInitialised' ]) {
        return key;
    }

    let translation = __(key);

    if (typeof translation === 'undefined'
        && store.state.localisation.keyCollector) {
        store.dispatch('localisation/addMissingKey', key);
    }

    translation = translation || key;
    if(params) {
        translation = translation.replace(/:(\w*)/g, function(e, key) {
            let param = params[key.toLowerCase()] || key;
            if(key === key.toUpperCase()) // param is uppercased
                param = param.toUpperCase();
            else if(key[0] === key[0].toUpperCase()) // first letter is uppercased
                param = param.charAt(0).toUpperCase() + param.slice(1);
            return param;
        });
    }
    return translation;
}

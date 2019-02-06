import store from '../../../store';

const setTenant = (config) => {
    if (store.state.tenant === null) {
        return;
    }

    if (config.data instanceof FormData) {
        config.data.append('_tenantId', store.state.tenant.id);
        return;
    }

    const tenant = {
        _tenantId: store.state.tenant.id,
    };

    if (config.method === 'get') {
        config.params = config.params
            ? { ...config.params, ...tenant }
            : tenant;
        return;
    }

    config.data = config.data
        ? { ...config.data, ...tenant }
        : tenant;
};

export default setTenant;

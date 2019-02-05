import store from '../../../store';

const setTenant = (config) => {
    if (store.state.tenant === null) {
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

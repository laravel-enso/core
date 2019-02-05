import axios from 'axios';
import setTenant from './tenantManager';

window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.request.use((config) => {
    setTenant(config);
    return config;
});

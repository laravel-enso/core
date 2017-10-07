import store from '../../../store';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.response.use(response => response, error => {
    const { status, data } = error.response;

    if (status === 455 || status === 403) {
        toastr.error(data.message);
    }

    if (status === 401 && store.getters['auth/isAuth']) {
    	toastr.error(data.message);
        store.dispatch('auth/logout');
    }

    return Promise.reject(error);
});
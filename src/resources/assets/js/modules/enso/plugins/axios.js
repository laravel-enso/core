import store from '../../../store';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.response.use(response => {
	return response;
}, error => {
    const { status, data } = error.response;

    if ([403, 409, 455].includes(status)) {
        toastr.error(data.message);
        throw new axios.Cancel();
    }

    if (status === 401 && store.getters['auth/isAuth']) {
    	toastr.error(data.message);
        store.dispatch('auth/logout');
        throw new axios.Cancel();
    }

    return Promise.reject(error);
});
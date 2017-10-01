Vue.mixin({
    methods: {
        handleError(error) {
            if (error.response.status === 401) {
                return this.$router.push({ path: '/login' });
            }

            if (error.response.data.message) {
                return toastr.error(error.response.data.message);
            }

            throw error;
        }
    }
});
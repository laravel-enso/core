var vue = new Vue({
    el: '#app',
    methods: {

        getExport: function() {

            axios.get('/core/export/getUsers').then((response) => {

                toastr["success"](response.data);
            });
        }
    }
});
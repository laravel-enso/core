var vue = new Vue({
    el: '#app',
    methods: {

        getExport: function() {

            axios.get('/export/getUsers').then((response) => {

                toastr["success"](response.data);
            });
        }
    }
});
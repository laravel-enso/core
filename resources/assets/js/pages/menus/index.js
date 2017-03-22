var vue = new Vue({
    el: '#app',
    methods: {
        customRender: function(column, data, type, row, meta) {
            switch(column) {
                case 'icon':
                        return '<i class="' + data + '"></i>';
                case 'created_at':
                    return moment(data).format("DD-MM-YYYY");
                case 'updated_at':
                    return moment(data).format("DD-MM-YYYY");
                default:
                    console.log('render for column ' + column + ' is not defined.' );
                    return data;
            }
        }
    }
});
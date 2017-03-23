var vue = new Vue({

    el: '#app',
    methods: {

        openFileBrowser: function() {

            $('input[name=avatar]').trigger('click');
        },
        submitAvatar: function() {

            var avatarFile = $('input[name=avatar]')[0].files[0];

            if (avatarFile) {

                var uploadUrl = $('#upload-avatar-form').attr('action'),
                    formData = new FormData();

                formData.append("avatar", avatarFile);

                axios.post(uploadUrl, formData).then((response) => {

                    $('.user-avatar').attr('src', '/core/avatars/' + response.data.saved_name);
                    $('#delete-avatar').data('avatar-id', response.data.id).removeClass('hidden');
                    $('input[name=avatar]').val('');
                });
            }
        },
        deleteAvatar: function(id) {

            axios.delete('/core/avatars/' + id).then((response) => {

                $('.user-avatar').attr('src', '/images/profile.png');
                $('#delete-avatar').addClass('hidden');
            });
        }
    }
});
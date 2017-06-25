@if (session()->has('flash_notification'))
    @push('scripts')
    <script>
        (function() {
            let flashMessages = {!! session()->has('flash_notification') ? session()->get('flash_notification') : null !!};

            flashMessages.forEach(flashMessage => {console.log(flashMessage);
                let level = flashMessage.level === 'danger' ? 'error' : flashMessage.level;
                toastr[level](flashMessage.message);
            });
        })();
    </script>
    @endpush
@elseif(count($errors))
    @push('scripts')
    <script>
        (function(){
            toastr.error('{{ __("The form contains errors") }}');
            let errors = {!! json_encode($errors->all()) !!};

            if(errors.length) {
                errors.forEach((error) => {
                    toastr.error(error);
                });
            }
        })();
    </script>
    @endpush
@endif

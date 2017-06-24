@if (session()->has('flash_notification.message'))
    @push('scripts')
    <script>
        (function() {
            let level = "{{ session('flash_notification.level') }}" === "danger" ? "error"
                : "{{ session('flash_notification.level') }}";
            toastr[level]("{{ session('flash_notification.message') }}!");
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

@if (session()->has('flash_notification'))
    @push('scripts')
    <script>
        (function() {
            let flashMessages = {!! session()->has('flash_notification') ? session()->get('flash_notification') : null !!};

            flashMessages.forEach(flashMessage => {
                let level = flashMessage.level === 'danger' ? 'error' : flashMessage.level;
                toastr[level](flashMessage.message);
            });
        })();
    </script>
    @endpush
@endif

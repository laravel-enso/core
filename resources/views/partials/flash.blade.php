@if (session()->has('flash_notification.message'))
    @push('scripts')
    <script>
    $(function() {
        var level = "{{ session('flash_notification.level') }}" == "danger"
            ? "error"
            : "{{ session('flash_notification.level') }}"
        toastr[level]("{{ session('flash_notification.message') }}!");
    });
    </script>
    @endpush
@elseif(count($errors))
    @push('scripts')
    <script>
    $(function(){
        toastr["error"]("{{ __("The form contains errors") }}");
    });
    </script>
    @endpush
@endif

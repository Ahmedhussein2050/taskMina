@if ($errors->any())
    @push('js')
        <script>
            @foreach ($errors->all() as $error)
                new Noty({
                type: 'error',
                layout: 'topRight',
                text: "{{ $error }}",
                timeout: 5000,
                killer: true
                }).show();
            @endforeach
            
        </script>
    @endpush
@endif
@if (Session::has('error_message'))
    @push('js')
        <script>
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: "{{ Session::get('error_message') }}",
                timeout: 2000,
                killer: true
            }).show();
        </script>
    @endpush
@endif
@if (Session::has('flash_message'))
    @push('js')
        <script>
            new Noty({
                type: 'success',
                layout: 'topRight',
                text: "{{ Session::get('flash_message') }}",
                timeout: 2000,
                killer: true
            }).show();
        </script>
    @endpush
@endif
@foreach (['error', 'warning', 'success', 'info'] as $msg)
    @if (Session::has($msg))
        @push('js')
            <script>
                new Noty({
                    type: $msg,
                    layout: 'topRight',
                    text: "{{ Session::get($msg) }}",
                    timeout: 2000,
                    killer: true
                }).show();
            </script>
        @endpush
    @endif
@endforeach

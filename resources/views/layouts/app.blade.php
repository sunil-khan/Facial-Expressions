<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
@stack('pre-styles')
@section('styles')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('js/datetimepicker/jquery.datetimepicker.min.css')}}"/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

        <style media="screen">
            #the-canvas
            {
                border: 1px solid black;
                direction: ltr;
            }
        </style>
@show

@stack('post-styles')
    <script type="text/javascript">
        var BASE_URL = "{{ url('/')}}";
    </script>
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('pre-scripts')

    @section('scripts')
        <script>
            window.Laravel = {!!  json_encode(['csrfToken' => csrf_token(), 'baseUrl' => url('/'), 'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; }) ]) !!};
            @if(Auth::check())
                window.Laravel.apiToken = '{{ Auth::user()->api_token }}';
            @endif
        </script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{asset('js/datetimepicker/jquery.datetimepicker.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                @if(Auth::check())
                ,'Authorization': 'Bearer ' + '{{ Auth::user()->api_token }}'
                @endif
            }
        });

        $(function(){
            $('#date_timepicker_start').datetimepicker({
                format:'Y-m-d',
                formatDate:'Y-m-d',
                scrollInput : false,
                onShow:function( ct ){
                    var date_timepicker_end = $('#date_timepicker_end').val()?$('#date_timepicker_end').val():false;
                    if(date_timepicker_end) {
                        var someDate = new Date(date_timepicker_end);
                        $('#date_timepicker_start').datetimepicker('setOptions', {maxDate: someDate});
                    }
                },
                onSelectDate:function (datetime) {
                    $('#date_timepicker_end').datetimepicker('setOptions',{minDate:datetime});
                },
                timepicker:false
            });
            $('#date_timepicker_end').datetimepicker({
                format:'Y-m-d',
                scrollInput : false,
                onShow:function( ct ){
                    var date_timepicker_start = $('#date_timepicker_start').val()?$('#date_timepicker_start').val():false;
                    if(date_timepicker_start) {
                        var someDate = new Date(date_timepicker_start);
                        $('#date_timepicker_end').datetimepicker('setOptions', {minDate: someDate});
                    }
                },
                onSelectDate:function (datetime) {
                    $('#date_timepicker_start').datetimepicker('setOptions',{maxDate:datetime});
                },
                timepicker:false
            });

            $('.select2').select2();
        });
    </script>

    @show



@stack('post-scripts')




</body>
</html>

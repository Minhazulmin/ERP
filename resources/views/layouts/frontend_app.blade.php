<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{URL::to('/')}}" />
    <link rel='icon' type='image/png' sizes='32x32' href="{{asset('images/favicon.png')}}">
    <script>
        window.laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseurl: '{{URL::to("/")}}'
        }
    </script>
    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/frontend_layouts.css') }}" rel="stylesheet">
</head>

<body>

    <div id="app">
        <app />
    </div>

    <!-- App js -->
    <script src="{{ asset('js/frontend_app.js') }}"></script>
    <script src="{{ asset('js/frontend_layouts.js') }}"></script>
</body>

</html>
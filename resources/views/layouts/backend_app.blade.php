<!DOCTYPE html>
<html>

<head data-baseurl="{{URL::to('/')}}">
    <meta charset="utf-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel='icon' type='image/png' sizes='32x32' href="{{asset('images/favicon.png')}}">
    <!-- no-cache -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{URL::to('/')}}" />
    <script>
        window.laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseurl: '{{URL::to("/")}}'
        }
    </script>
    <title>{{ config('app.name') }}</title>
    <!-- Font Awesome Ionicons -->
    <link rel="stylesheet" href="{{ asset('packages/font-awesome/css/font-awesome.min.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend_layouts.css') }}" rel="stylesheet">
</head>

<body class="hold-transition skin-blue sidebar-mini body">
    <div id="app">
        <app />
    </div>

    <!-- App js -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/backend_layouts.js') }}" defer></script>
</body>

</html>

<!DOCTYPE html>

<head>
    <title>Facebook Tools</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" media="screen" href="{!! url('public/css/style.css') !!}">
    <script src="{!! url('public/js/animation.js') !!}"></script>
</head>
<html>

<body>

    @include('facebook.header')
    <div class="container">
        @yield('content')
    </div>
    @include('facebook.footer')
</body>

</html>
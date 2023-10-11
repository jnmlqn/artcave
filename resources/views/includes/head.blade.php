<head>
	<title>{{$title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('styles')
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/public/css/aos/aos.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/public/css/web.css">
    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/public/css/swal/swal.css">
    <link rel="stylesheet" type="text/css" href="/public/css/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    <script type="text/javascript" src="/public/js/aos/aos.min.js"></script>
    <script type="text/javascript" src="/public/js/jquery/jquery.js"></script>
    <script type="text/javascript" src="/public/js/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="/public/js/jquery-ui/jquery-ui.js"></script>
    <script type="text/javascript" src="/public/js/pagination.js"></script>
    <script type="text/javascript" src="/public/js/swal/swal.js"></script>
</head>
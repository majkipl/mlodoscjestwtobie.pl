<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charSet="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="xx"/>
    <meta name="keywords" content="xxx"/>

    <!--Facebook Like Button OpenGraph Settings Start-->

    <meta property="og:type" content="website"/>

    @isset($contest)
        <meta property="og:url" content="{{ route('front.application.id', ['contest' => $contest->id]) }}"/>
        @if($contest->img_tip)
            <meta property="og:image" content="{{ asset('storage/' . $contest->img_tip) }}"/>
        @endif
        @if($contest->video_type == 'youtube')
            <meta property="og:image" content="{{ $contest->video_image_id }}"/>
        @endif
        @if($contest->video_type == 'vimeo')
            <meta property="og:image" content="{{ $contest->video_image_id }}"/>
        @endif
        <meta property="og:site_name" content="{{ $contest->title }}"/>
        <meta property="og:title" content="{{ $contest->title }}"/>
        <meta name="dcterms.Title" content="{{ $contest->title }}"/>
        <meta name="dcterms.Subject" content="{{ $contest->title }}"/>

        <meta property="og:description" content="{{ $contest->message }}"/>
    @else
        <meta property="og:url" content="{{ route('front.home') }}"/>
        <meta property="og:image" content="{{ asset('images/kv-men.jpg') }}"/>
        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}"/>
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }}"/>
        <meta name="dcterms.Title" content="{{ config('app.name', 'Laravel') }}"/>
        <meta name="dcterms.Subject" content="{{ config('app.name', 'Laravel') }}"/>

        <meta property="og:description" content="xxx"/>
    @endisset

    <meta property="og:image:width" content="330"/>
    <meta property="og:image:height" content="330"/>
    <meta property="fb:app_id" content="869984166500416"/>

    {{--    <!--Facebook Like Button OpenGraph Settings End-->--}}

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-1.11.3.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.ui.core.1.10.3.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.ui.widget.1.10.3.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.ui.mouse.1.10.3.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.ui.draggable.1.10.3.min.js') }}" defer></script>
    <script src="{{ asset('js/selectbox/jquery.selectbox-0.2.js') }}" defer></script>
    <script src="{{ asset('js/owl/owl.carousel.min.js') }}" defer></script>
    <script src="{{ asset('js/jkit/jquery.jkit.1.2.16.js') }}" defer></script>
    <script src="{{ asset('js/slidepushmenu/classie.js') }}" defer></script>
    <script src="{{ asset('js/slidepushmenu/modernizr.custom.js') }}" defer></script>
    <script src="{{ asset('js/mcustomscrollbar/jquery.mCustomScrollbar.js') }}" defer></script>
    <script src="https://unpkg.com/axios@0.16.2/dist/axios.min.js"></script>
    <script src="{{ asset('js/moment/min/moment-with-locales.min.js') }}" defer></script>
    <script src="{{ asset('js/datetimepicker/bootstrap-datetimepicker.min.js') }}" defer></script>
    <script src="{{ asset('js/starter.js') }}" defer></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <script src="https://use.typekit.net/ule5nuh.js"></script>
    <script>
        try {
            Typekit.load({async: true});
        } catch (e) {
        }
    </script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/rabbits.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/selectbox/jquery.selectbox.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/owl/owl.carousel.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/owl/owl.theme.default.min.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/mcustomscrollbar/jquery.mCustomScrollbar.css') }}" type="text/css"
          media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/hamburger/hamburgers.min.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/datetimepicker/bootstrap-datetimepicker.min.css') }}" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/starter.css') }}" type="text/css">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
</head>

<body class="cbp-spmenu-push{{ isset($include_body_class) ? ' ' . $include_body_class : '' }}">

@include('common.loader')
@include('common.top')

@yield('content')

@include('common.partners')
@include('common.footer')

</body>
</html>

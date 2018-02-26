<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $pageTitle ?? __('admin.header.dashboard') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="XYZ123">
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("/css/all-skins.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("/css/custom.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("/css/dropzone.css")}}" rel="stylesheet" type="text/css"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset ("/js/jquery-3.2.1.min.js") }}"></script>
</head>
<body class="skin-blue">
<div class="wrapper">

    @include('admin.parts.header')

    @include('admin.parts.sidebar')

    <div class="content-wrapper">
        {{--<section class="content-header">
            <h1>
                {{ $pageTitle ?? '' }}
                <small>{{ $page_description ?? '' }}</small>
            </h1>
        </section>--}}

        <section class="content">
            @yield('content')
        </section>
    </div>

    @include('admin.parts.footer')

</div>

<script src="{{ asset ("/js/bootstrap.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/app.min.js") }}" type="text/javascript"></script>
</body>
</html>
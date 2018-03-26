<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @foreach($metaTags as $metaTag)
        <meta name="{{ $metaTag['name'] }}" content="{{ $metaTag['content'] }}">
    @endforeach
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $pageTitle }}</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="/js/jquery.bxslider.js"></script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script src="/js/common.js"></script>
    <script type="text/javascript" src="http://js.i.dinnerbooking.eu/onlinebooking.js"></script>

    <link rel="stylesheet" href="/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="/css/jquery.bxslider.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="{{ $currentRoute }}">

{{--<center style="position:fixed; top: 0;">@lang('site.index.title')</center>--}}

@include('site.parts.mainMenu')

@include('site.parts.header')

@yield('container')

<script>
    $(document).ready(function () {
        var $this =  $(this),
            $documentHeight = $this.outerHeight(),
            topMargin = parseInt($('.container').css('marginLeft'));
        
        $('.container').css('marginTop', $documentHeight).show();
        $('.container__main-img').height($documentHeight/2.5);

        setTimeout(function () {
            $('.container').css('marginTop', topMargin);
        }, 250);

//        $('.js-scroll').on('click', function () {
//            var $this = $(this);
//            $('html, body').animate({
//                scrollTop: $this.parent().next(".container__title").offset().top - 30
//            }, 1000);
//        });
//         if ($(".container__title").length){
//             setTimeout(function () {
//                 $('html, body').animate({
//                     scrollTop: $(".container > .container__title").offset().top
//                 }, 1000);
//             }, 750)
//         }

    });
</script>
</body>
</html>
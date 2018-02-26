<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('site.404')</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="/js/jquery.bxslider.js"></script>
    <script type="text/javascript" src="http://js.i.dinnerbooking.eu/onlinebooking.js"></script>
    <link rel="stylesheet" href="/css/jquery.bxslider.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>


@include('site.parts.mainMenu')

@include('site.parts.header')

<div class="error">
        <div class="error__title"><span>@lang('site.404')</span></div>
</div>

<script>
    $(document).ready(function () {
        var $this =  $(this),
            $documentHeight = $this.outerHeight(),
            topMargin = parseInt($('.container').css('marginLeft'));

        $('.container').css('marginTop', $documentHeight).show();
        $('.container__main-img').height($documentHeight - (topMargin*2));

        setTimeout(function () {
            $('.container').css('marginTop', topMargin);
        }, 250);

        $('.js-scroll').on('click', function () {
            var $this = $(this);
            $('html, body').animate({
                scrollTop: $this.parent().next(".container__title").offset().top - 30
            }, 1000);
        });
    });
</script>
</body>
</html>
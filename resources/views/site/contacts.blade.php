@extends('site.layout')

@section('container')
    <div class="container">
        <div id="what" class="container__main-img " style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.contacts.title')</div>
            {{--<div class="container__scroll-btn js-scroll"></div>--}}
        </div>
        {{--<span class="container__title"></span>--}}
        {{--<span class="container__subtitle"></span>--}}
        @if($item)
            <div class="contacts__wrapper">

                <div class="contacts__content">
                    <div class="contacts__text">
                        <div class="contacts__title">St. Petrus</div>
                        <div class="contacts__address">{{ $item['address'] }}</div>
                        <div class="contacts__phone">Phone: {{ $item['phone'] }}<br>Email: {{ $item['email'] }}</div>

                        <div class="contacts__form-wrapper">
                            <div class="contacts__form-title">@lang('site.contacts.formtitle')</div>

                            @include('site.parts.orderForm')

                        </div>

                        <div class="contacts__social">
                            <div class="contacts__social-title">@lang('site.socialTitle')</div>
                            @foreach(\App\Social::whereDisabled(false)->orderBy('order')->get()->toArray() as $social)
                                <a class="mainMenu__social-item" title="{{ $social['title'] }}" style="background: url({{ asset($social['image']) }}) no-repeat;" href="{{ $social['url'] }}" target="_blank"></a>
                            @endforeach
                        </div>
                    </div>



                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqtEJkeFUcmP7nLeKvXDF42mdrWwHy7NI&callback=initMap"></script>
                </div>
                <div id="map" class="contacts__map"><?//= $item['map_link'] ?></div>
            </div>
        @endif
    </div>

    <script src="/js/jquery.datetimepicker.full.min.js"></script>

    <script>
        $(function () {
            var showOrderPopup = '<?=isset($_GET['order-table'])?>';
            if (showOrderPopup == true) openDBWindow($('#order-table').attr('href'));
        });

        function initMap(){
            var uluru = {lat: 56.9478799, lng: 24.1095129},
                grayStyles = [{
                    featureType: "all",
                    stylers: [
                        { saturation: -100 },
                        { lightness: 0 }
                    ]
                }],
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 17,
                    center: uluru,
                    styles: grayStyles
                }),
                marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });
        }
    </script>
@endsection

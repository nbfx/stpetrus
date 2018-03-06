@extends('site.layout')

@section('container')
    <div class="container">
        <div id="what" class="container__main-img " style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.contacts.title')</div>
            {{--<div class="container__scroll-btn js-scroll"></div>--}}
        </div>
        <span class="container__title">
        </span>
        <span class="container__subtitle">
        </span>
        @if($item)
            <div class="contacts__wrapper">

                <div class="contacts__text">
                    <div class="contacts__title">St. Petrus</div>
                    <div class="contacts__address">{{ $item['address'] }}</div>
                    <div class="contacts__phone">Phone: {{ $item['phone'] }}<br>Email: {{ $item['email'] }}</div>

                    <a class="contacts__btn contacts__btn_order" target="_blank" onclick="return openDBWindow(this.href);" href="http://stpetrus.b.dinnerbooking.com/onlinebooking/1202/2" title="Make a booking" id="order-table">@lang('site.order')</a>
                    <a href="mailto:{{ $item['email'] }}" class="contacts__btn contacts__btn_emailus">@lang('site.contacts.email')</a>
                    <div class="contacts__btn contacts__btn_findus">@lang('site.contacts.findUs')</div>

                    <div class="contacts__form-wrapper">
                        <div class="contacts__form-title">@lang('site.contacts.formtitle')</div>
                        <form method="post" id="feedback_form" action="{{ route('feedback') }}">
                            {{--TODO--}}
                            <div class="contacts__field contacts__field_firstName">
                                <input id="firstName" class="contacts__input" type="text" placeholder="First name">
                            </div>
                            <div class="contacts__field contacts__field_lastName">
                                <input id="lastName" class="contacts__input" type="text" placeholder="Lastname">
                            </div>
                            <div class="contacts__field contacts__field_phone">
                                <input id="phone" class="contacts__input" type="text" placeholder="Phone">
                            </div>
                            <div class="contacts__field contacts__field_email">
                                <input id="email" class="contacts__input" type="text" placeholder="E-Mail">
                            </div>
                            <div class="contacts__field contacts__field_date">
                                <input id="date" class="contacts__input" type="text" placeholder="Date">
                            </div>
                            <div class="contacts__field contacts__field_num">
                                <input id="num" class="contacts__input" type="text" placeholder="Number of persons">
                            </div>
                            <div class="contacts__field contacts__field_text">
                                <textarea class="contacts__textarea" name="" id="text" cols="30" rows="4"  placeholder="Enter Your Request"></textarea>
                            </div>
                            <div class="contacts__submit">
                                <input class="contacts__submit-btn" type="submit" value="Send">
                            </div>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        </form>
                    </div>

                    <div class="contacts__social">
                        <div class="contacts__social-title">@lang('site.socialTitle')</div>
                        @foreach(\App\Social::whereDisabled(false)->orderBy('order')->get()->toArray() as $social)
                            <a class="mainMenu__social-item" title="{{ $social['title'] }}" style="background: url({{ asset($social['image']) }}) no-repeat;" href="{{ $social['url'] }}" target="_blank"></a>
                        @endforeach
                    </div>
                </div>


                <div id="map" class="contacts__map"><?//= $item['map_link'] ?></div>
                <script>
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
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqtEJkeFUcmP7nLeKvXDF42mdrWwHy7NI&callback=initMap"></script>
            </div>
        @endif
    </div>
    <script>
        $(function () {
            var showOrderPopup = '<?=isset($_GET['order-table'])?>';
            if (showOrderPopup == true) openDBWindow($('#order-table').attr('href'));
        });

        $('#feedback_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data){
                    console.log(data);
                },
                error: function(data){

                }
            });
        })
    </script>
@endsection

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
                            <form method="post" id="feedback_form" action="{{ route('feedback') }}">
                                {{--TODO--}}
                                <div class="contacts__field contacts__field_firstName">
                                    <input id="firstName" name="first_name" class="contacts__input" type="text" placeholder="First name">
                                </div>
                                <div class="contacts__field contacts__field_lastName">
                                    <input id="lastName" name="last_name" class="contacts__input" type="text" placeholder="Lastname">
                                </div>
                                <div class="contacts__field contacts__field_phone">
                                    <input id="phone" name="phone" class="contacts__input" type="text" placeholder="Phone">
                                </div>
                                <div class="contacts__field contacts__field_email">
                                    <input id="email" name="email" class="contacts__input" type="text" placeholder="E-Mail">
                                </div>
                                <div class="contacts__field contacts__field_date">
                                    <input id="date" name="date_time" class="contacts__input" type="text" placeholder="Date">
                                </div>
                                <div class="contacts__field contacts__field_num">
                                    <input id="num" name="people_amount" class="contacts__input" type="text" placeholder="Number of persons">
                                </div>
                                <div class="contacts__field contacts__field_text">
                                    <textarea class="contacts__textarea" name="description" id="text" cols="30" rows="4"  placeholder="Enter Your Request"></textarea>
                                </div>

                                <div class="contacts__submit">
                                    <input class="contacts__submit-btn" type="submit" value="Send">
                                </div>
                                <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            </form>
                            <span id="response-message" style="display: none;"></span>
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

        $(function(){
            $.datetimepicker.setLocale('{{ app()->getLocale() }}');
            $('[name=date_time]').datetimepicker({
                format: 'd.m.Y H:i',

            });
        });

        $('#feedback_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data){
                    $('.feedback-error').remove();
                    if (data.errors !== undefined) {
                        $.each(data.errors, function (name, item) {
                            $('[name='+name+']').parent().append('<span class="feedback-error">'+item[0]+'</span>');
                        })
                    } else {
                        $('#feedback_form').fadeOut(250, function () {
                            $('#response-message').text(data.message).fadeIn(250);
                        });
                    }
                },
                error: function(data){
                    $('#response-message').text('Internal error! Try again later!');
                }
            });
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

@extends('site.layout')

@section('container')
    <?php $dates = [];?>
    <link rel="stylesheet" href="{{ asset('css/clndr.css') }}">
    <div class="container">
        <div class="container__main-img" style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.events.title')</div>
            {{--<div class="container__scroll-btn js-scroll"></div>--}}
        </div>
        <div class="events__wrapper">
            <div id="events__calendar" class="events__calendar"></div>
            @if($items)
                @foreach($items as $item)
                    <?php $item['date_time'] ? $dates[] = date('Y-m-d', strtotime($item['date_time'])):false;?>
                    <div class="events__item" {{ $item['date_time'] ? 'id=event-'.date('Y-m-d', strtotime($item['date_time'])) : ''}}>
                        @if($item['image'])
                            <img class="events__img" src="{{ asset($item['image'] ?? '') }}" alt="">
                        @endif
                        <div class="events__item-title">{{ $item['title'] }}</div>
                        <div class="events__text"><?=$item['text']?></div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('js/underscore-min.js') }}"></script>
    <script src="{{ asset('js/clndr.js') }}"></script>
    <script>
        moment.locale('{{ $currentLocale }}');
        $('#events__calendar').clndr({
            moment: moment,
            showAdjacentMonths: false,
            template: $('#calendar-template').html(),
            events: [
                <?php foreach ($dates as $date) {
                    echo "{ date: '$date' },";
                }?>
            ],
            clickEvents: {
                click: function(target) {
                    if (target.date != undefined && $(target.element).hasClass('event')) {
                        $('html, body').animate({
                            scrollTop: $( "#event-"+target.date.format('YYYY-MM-DD')).offset().top
                        }, 500);
                    }
                }
            }
        });
    </script>
@endsection
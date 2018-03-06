@extends('site.layout')

@section('container')
    <div class="container">
        <div id="team" class="container__main-img" style="background: url({{ asset($activeMenu['children'][0]['image'] ?? '') }}) center no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">{{ $activeMenu['children'][0]['title'] ?? '' }}</div>
            {{--<div class="container__scroll-btn js-scroll"></div>--}}
        </div>
        <span class="container__title">
            @lang('site.who.ourTeam')
        </span>
        <span class="container__subtitle">
            @lang('site.who.subTitle')
        </span>
        {{--TEAMMATES--}}
        <div class="listing">
            @if($items && !empty($items['teammates']))
                @foreach($items['teammates'] as $teammate)
                <div class="listing__item">
                    <div class="listing__text">
                        <span class="listing__position">{{ $teammate['position'] }}</span>
                        <span class="listing__name">{{ $teammate['title'] }}</span>

                        <span class="listing__description">
                            {{ $teammate['text'] }}
                        </span>
                    </div>
                    <div class="listing__img">
                        <img src="{{ asset($teammate['image']) }}" alt="">
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    {{--HISTORY--}}
    <div class="container__main-img" style="background: url({{ asset($activeMenu['children'][1]['image'] ?? '') }}) center no-repeat; background-size: cover;">
        <div class="container__main-title js-scroll">{{ $activeMenu['children'][1]['title'] ?? '' }}</div>
        {{--<div class="container__scroll-btn js-scroll"></div>--}}
    </div>
    <span id="history" class="container__title"></span>
    <div class="listing">
        @if($items && !empty($items['histories']))
            @foreach($items['histories'] as $history)
                <div class="listing__item">
                    <div class="listing__text">
                        <span class="listing__position">{{ $history['description'] }}</span>
                        <span class="listing__name">{{ $history['title'] }}</span>

                        <span class="listing__description">
                            {{ $history['text'] }}
                        </span>
                    </div>
                    <div class="listing__img">
                        <img src="{{ asset($history['image']) }}" alt="">
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
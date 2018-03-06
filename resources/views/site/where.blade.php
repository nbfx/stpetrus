@extends('site.layout')

@section('container')
    <div class="container">
        <div id="where" class="container__main-img" style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.where.title')</div>
            {{--<div class="container__scroll-btn js-scroll"></div>--}}
        </div>
        <span class="container__title">
            @lang('site.where.whereWe')
        </span>
        <span class="container__subtitle">
            @lang('site.where.subTitle')
        </span>

        <div class="listing">
            @if($items)
                @foreach($items as $item)
                    <div class="listing__item">
                        <div class="listing__text">
                            <span class="listing__position">{{ $item['description'] }}</span>
                            <span class="listing__name">{{ $item['title'] }}</span>

                            <span class="listing__description">
                            {{ $item['text'] }}
                        </span>
                        </div>
                        <div class="listing__img">
                            <img src="{{ asset($item['image']) }}" alt="">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
@endsection
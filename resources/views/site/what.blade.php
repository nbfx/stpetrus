@extends('site.layout')

@section('container')

    <div class="container">
        <div id="what" class="container__main-img" style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.what.title')</div>
            <div  class="container__scroll-btn js-scroll"></div>
        </div>

        <span class="container__title">
        @lang('site.what.ourMenu')
        </span>
        <span class="container__subtitle">
        @lang('site.what.subTitle')
        </span>

        <div class="listing">

        @if($items)
            @foreach($items as $item)
            <div class="listing__item">
                <div class="listing__text">
                    <div class="listing__title">{{ $item['title'] }}</div>
                    <div class="listing__description-title">Description:</div>
                    <div class="listing__description">{{ $item['description'] }}</div>
                </div>
                <div class="listing__img">
                    <img src="{{ asset($item['image']) }}" alt="">
                </div>
            </div>
            @endforeach
        @endif
        </div>

    </div>

@endsection


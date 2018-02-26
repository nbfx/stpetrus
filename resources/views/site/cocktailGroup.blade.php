@extends('site.layout')

@section('container')
    <div class="container">
        <div id="mainMenu" class="container__main-img" style="background: url({{ asset($headerImage ?? '') }}) no-repeat;background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.cocktails.title')</div>
            <div class="container__scroll-btn js-scroll"></div>
        </div>
        {{--<span class="container__title">
            @lang('site.menu.title')
        </span>--}}
        <span class="container__subtitle"></span>
        <div class="category__wrapper">
            <div class="category">
                <div class="category__img" style="background:url('{{ asset($items['image'] ?? '') }}'); background-size: cover; background-position: center;"></div>
                {{--<img class="category__img" src="{{ asset($items['image']) }}" alt="">--}}

                @if($items && !empty($items['children']))
                    @foreach($items['children'] as $child)
                        <div class="category__sub-items">
                            <span class="category__dish">{{ $child['title'] }}{{$child['price'] ? '/'.config('app.currency').$child['price'] : '' }}</span>
                            <span class="category__description">{{ $child['description'] }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
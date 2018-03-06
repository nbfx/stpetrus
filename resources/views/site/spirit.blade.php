@extends('site.layout')

@section('container')
    <div class="container">
        <div id="what" class="container__main-img " style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;background-position: center center;">
            <div class="container__main-title js-scroll">@lang('site.spirits.title')</div>
            {{--<div class="container__scroll-btn js-scroll"></div>--}}
        </div>
        <span class="container__title">
            @lang('site.spirits.title')
        </span>
        <div class="category__wrapper">
            <div class="category">
                @if($items)
                    @foreach($items as $item)

                        <a href="{{ route('spiritGroup', ['group' => $item['name']]) }}" class="category__item" style="background: url('{{ asset($item['preview_image'] ?? '') }}'); background-size: cover;">
                            <div class="category__title">{{ $item['title'] }}</div>
                            <div class="category__size">{{ $item['description'] }}</div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
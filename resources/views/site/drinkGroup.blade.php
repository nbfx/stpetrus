@extends('site.layout')

@section('container')
    <div class="container">
        <div id="what" class="container__main-img " style="background: url({{ asset($items['image'] ?? '') }}) no-repeat; background-size: cover;background-position: center center;">
            <div class="container__main-title js-scroll">{{ $items['title'] }}</div>
            <div class="container__scroll-btn js-scroll"></div>
        </div>
        <span class="container__title">
            {{ $items['title'] }}
        </span>
        <div class="category__wrapper">
            <div class="category">
                @if($items['children'])
                    @foreach($items['children'] as $item)
                        <a href="{{ route('drinkSubgroup', ['group' => $group, 'subgroup' => $item['name']]) }}" class="category__item" style="background: url('{{ asset($item['preview_image'] ?? '') }}'); background-size: cover;">
                            <div class="category__title">{{ $item['title'] }}</div>
                            <div class="category__size">{{ $item['description'] }}</div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
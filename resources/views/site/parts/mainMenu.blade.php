<div class="overlay"></div>
<div class="mainMenu__wrapper">
    <div class="mainMenu">
        <div class="sandwich"></div>
        <a href="/" class="mainMenu__logo">
            <img src="/img/logo.jpg" alt="LOGO">
        </a>
        <div class="mainMenu__list">
            @foreach($mainMenu as $id => $menuItem)
                <span data-route="{{ route($menuItem['name']) }}" class="mainMenu__item {{ $menuItem['active'] ? 'active' : '' }}" data-id="{{ $id }}">
                    {{ $menuItem['title'] }}
                </span>
            @endforeach
        </div>

        <a class="mainMenu__btn" target="_blank" title="Make a booking">@lang('site.order')</a>

        @include('site.parts.languages')

        <span class="mainMenu__social">
        <span class="mainMenu__social-title">@lang('site.socialTitle')</span>
            @foreach(\App\Social::whereDisabled('false')->orderBy('order')->get()->toArray() as $social)
                <a class="mainMenu__social-item" title="{{ $social['title'] }}" style="background: url({{ asset($social['image']) }}) no-repeat; background-size: contain" href="{{ $social['url'] }}" target="_blank"></a>
            @endforeach
    </span>
    </div>
    <div id="qwe" class="mainMenu__submenu">
        @foreach($mainMenu as $id => $menuItem)
            @if($menuItem['children'])
                <span class="mainMenu__submenu-item {{ count($menuItem['children']) > 1 ? 'multiple' : '' }}" data-id="{{ $id }}">
                    @foreach($menuItem['children'] as $child)
                        <span class="mainMenu__submenu-section" style="background-image: url('{{ asset($child['image']) }}'); background-position: center; background-size: cover;" data-id="{{ $id }}">
                            <a href="{{ route($menuItem['name']).(count($menuItem['children']) > 1 ? "#$child[name]" : '') }}" class="mainMenu__submenu-btn">{{ $child['title'] }}</a>
                        </span>
                    @endforeach
                </span>
            @else
                <span class="mainMenu__submenu-item" data-id="{{ $id }}">
                    <a href="" class="mainMenu__submenu-section" style="background-image: url('{{ asset($menuItem['image']) }}'); background-position: center; background-size: cover;">
                        <span href="" class="mainMenu__submenu-btn">{{ $menuItem['title'] }}</span>
                    </a>
                </span>
            @endif
        @endforeach
    </div>
</div>

<div class="orderFormPopUp">
    <div class="orderFormPopUp__wrapper">
        <div class="orderFormPopUp__title">Заказать столик<div class="orderFormPopUp__close"></div></div>
        @include('site.parts.orderForm')
    </div>
</div>
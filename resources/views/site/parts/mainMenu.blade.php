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

        <a class="mainMenu__btn" target="_blank" onclick="return openDBWindow(this.href);" href="http://stpetrus.b.dinnerbooking.com/onlinebooking/1202/2" title="Make a booking">@lang('site.order')</a>

        @include('site.parts.languages')

        <span class="mainMenu__social">
        <span class="mainMenu__social-title">@lang('site.socialTitle')</span>
        <a class="mainMenu__social-item mainMenu__social-item_fb" href="#" target="_blank"></a>
        <a class="mainMenu__social-item mainMenu__social-item_insta" href="#" target="_blank"></a>
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

<?//
//dump($mainMenu)
//?>

<script>
    $(document).ready(function () {
        var $menu = $('.mainMenu'),
            $menuItem = $('.mainMenu__item'),
            $subMenu = $('.mainMenu__submenu'),
            menuHeight = $menu.outerHeight(),
            menuWidth = $menu.outerWidth(),
            $menuWrapper = $('.mainMenu__wrapper'),
            $subMenuItem = $('.mainMenu__submenu-item '),
            windowWidth = $(document).width(),
            dataIdLast = 0,
            setMenuWidth,
            openSubMenu,
            $window = $(window),
            $sandwich = $('.sandwich');

        $menuWrapper.height(menuHeight);

        setMenuWidth = function ($el) {
            var windowWidth = $el.width(),
                responsWidth = windowWidth / 100 * 30;

            menuWidth = $menu.outerWidth();

            if (windowWidth > 1280) {
                windowWidth = 1280;
            }
            if (windowWidth < 1280) {
                $menu.width(responsWidth);
                $menu.css('paddingRight', responsWidth / 5.48);
            }
        };
        openSubMenu = function () {
            if ($subMenu.width() == 0) {
                $subMenu.css('width', windowWidth - menuWidth - 70);

            } else {
                $subMenu.stop(true, false).css('width', 0);
            }
        };

        $menuItem.on('click', function () {
            $subMenu.stop(true, false);
            var dataId = $(this).data('id');

            if ($subMenu.width() > 0) {
                if ($(this).hasClass('active')) {
                    $menuItem.removeClass('active');
                    $(this).addClass('active');
                    openSubMenu();
                } else {
                    $menuItem.removeClass('active');
                    $(this).addClass('active');

                    var animationTime = 400,
                        difference = Math.abs(dataIdLast - dataId);

                    if (difference > 1) {
                        animationTime = animationTime * difference / 1.2;
                        console.log(animationTime); //TODO
                    }

                    $subMenu.animate({
                        marginTop: -menuHeight * dataId
                    }, animationTime);
                    dataIdLast = dataId;
                }

            } else {
                $subMenu.css("marginTop", -menuHeight * dataId);
                $menuItem.removeClass('active');
                $(this).addClass('active');
                openSubMenu();
            }
            $subMenuItem.height(menuHeight);
        });

        $("body").click(function (e) {
            if ($(e.target).closest($menuWrapper).length == 0) {
                $subMenu.stop(true, false).css('width', 0);
            }
        });

        $window.resize(function () {
            var $el = $(this);
            setMenuWidth($el);
        });
        setMenuWidth($window);

        if ($window.width() < 800) {
            var tmpWidth = $menu.width(),
                tmpHeight = $menu.height();

            hideMenu = function () {
                $menu.animate({
                    height: "20px",
                    width: "27px",
                    padding: "5px"
                }, 250);
                $menuWrapper.animate({
                    height: 30
                },150);
                $menu.addClass('mobile');
            };
            showMenu = function () {
                $menu.animate({
                    height: tmpHeight,
                    width: tmpWidth,
                    paddingRight: windowWidth / 100 * 30 / 5.48,
                    paddingLeft: 0
                }, 250);
                $menuWrapper.animate({height: tmpHeight}, 250);
                $menu.removeClass('mobile');
            };

            $sandwich.show();

            $sandwich.on('click', function () {
                if ($menu.hasClass('mobile')) {
                    showMenu();
                } else {
                    hideMenu();
                }
            });
            hideMenu();
        }
    });
</script>
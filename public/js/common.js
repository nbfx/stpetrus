$(document).ready(function () {
    $(function(){
        $.datetimepicker.setLocale('{{ app()->getLocale() }}');
        $('[name=date_time]').datetimepicker({
            format: 'd.m.Y H:i'
        });
    });

    //mainMenu Start
    var $window = $(window),
        $menu = $('.mainMenu'),
        $menuItem = $('.mainMenu__item'),
        $subMenu = $('.mainMenu__submenu'),
        menuHeight = $menu.outerHeight(),
        menuWidth = $menu.outerWidth(),
        $menuWrapper = $('.mainMenu__wrapper'),
        $subMenuItem = $('.mainMenu__submenu-item '),
        $sandwich = $('.sandwich'),
        windowWidth = $(document).width(),
        dataIdLast = 0,
        menuPaddings = 0,
        setMenuWidth,
        openSubMenu;

    $menuWrapper.height(menuHeight);

    setMenuWidth = function ($el) {
        var windowWidth = $el.width(),
            responsWidth = windowWidth / 100 * 30;

        menuWidth = $menu.outerWidth();

        windowWidth < 1366 ? menuPaddings = 0 : menuPaddings = 70;

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
            $subMenu.css('width', windowWidth - menuWidth - menuPaddings);

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

    $('.mainMenu__btn').on('click', function () {
        $('.orderFormPopUp').fadeIn(250);
    });
    $('.orderFormPopUp__close').on('click', function () {
        $('.orderFormPopUp').fadeOut(250);
    });

    $(document).on('click', '.orderFormPopUp', function(e){
        if($(e.target).hasClass('orderFormPopUp')){
            $('.orderFormPopUp').fadeOut(250);
        }
    });
    //mainMenu END

    $('.feedback_form').on('submit', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data){
                $('.feedback-error', $this).remove();
                if (data.errors !== undefined) {
                    console.log($(this)); //TODO
                    $.each(data.errors, function (name, item) {
                        $this.find('[name='+name+']').parent().append('<span class="feedback-error">'+item[0]+'</span>');
                    });

                } else {
                    $this.fadeOut(250, function () {
                        $this.next('.response-message').text(data.message).fadeIn(250);
                    });
                }
            },
            error: function(data){
                $('#response-message').text('Internal error! Try again later!');
            }
        });
    });

    var $this =  $(this),
        $documentHeight = $this.outerHeight(),
        topMargin = parseInt($('.container').css('marginLeft'));

    $('.container').css('marginTop', $documentHeight).show();
    $('.container__main-img').height($documentHeight/2.5);

    setTimeout(function () {
        $('.container').css('marginTop', topMargin);
    }, 250);

});
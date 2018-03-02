@extends('site.layout')

@section('container')
    <div class="container">
        <div id="what" class="container__main-img " style="background: url({{ asset($activeMenu['image'] ?? '') }}) no-repeat; background-size: cover;">
            <div class="container__main-title js-scroll">@lang('site.contacts.title')</div>
            <div class="container__scroll-btn js-scroll"></div>
        </div>
        <span class="container__title">
        </span>
        <span class="container__subtitle">
        </span>
        @if($item)
            <div class="contacts__wrapper">
                <div class="contacts__text">
                    <div class="contacts__title">St. Petrus</div>
                    <div class="contacts__address">{{ $item['address'] }}</div>
                    <div class="contacts__phone">Phone: {{ $item['phone'] }}<br>Email: {{ $item['email'] }}</div>

                    <a class="contacts__btn contacts__btn_order" target="_blank" onclick="return openDBWindow(this.href);" href="http://stpetrus.b.dinnerbooking.com/onlinebooking/1202/2" title="Make a booking" id="order-table">@lang('site.order')</a>
                    <a href="mailto:{{ $item['email'] }}" class="contacts__btn contacts__btn_emailus">@lang('site.contacts.email')</a>
                    <div class="contacts__btn contacts__btn_findus">@lang('site.contacts.findUs')</div>


                    <div class="contacts__social">
                        <div class="contacts__social-title">@lang('site.socialTitle')</div>
                        @foreach(\App\Social::whereDisabled(false)->orderBy('order')->get()->toArray() as $social)
                            <a class="mainMenu__social-item" title="{{ $social['title'] }}" style="background: url({{ asset($social['image']) }}) no-repeat;" href="{{ $social['url'] }}" target="_blank"></a>
                        @endforeach
                    </div>
                </div>
                <div class="contacts__map"><?= $item['map_link'] ?></div>
            </div>
        @endif
    </div>
    <script>
        $(function () {
            var showOrderPopup = '<?=isset($_GET['order-table'])?>';
            if (showOrderPopup == true) openDBWindow($('#order-table').attr('href'));
        });
    </script>
@endsection

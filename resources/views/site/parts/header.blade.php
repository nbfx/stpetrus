<?php $slider = App\Slider::first(); ?>
<div class="header">
    <ul class="bxslider" style="height: 100% !important;">
        @foreach(App\Slider::getChildren($slider->id, true) as $slide)
            <li style="background:url('{{ asset($slide->image) }}'); background-size: cover;"></li>
        @endforeach
    </ul>
</div>
<script>
    $(document).ready(function () {
        $('.bxslider').bxSlider({
            speed: '{{ $slider->speed_ms }}',
            pause: '{{ $slider->pause_ms }}',
            pager: false,
            controls: false,
            responsive: true,
            autoStart: true,
            auto: true,
            easing: 'ease'
        });
    });
</script>
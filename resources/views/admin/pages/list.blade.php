@extends('admin.layout')

@section('content')
    <div class='row'>
        <div class='col-md-10'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $pageTitle }}</h3>
                    <div class="box-tools pull-right">
                        @if($isRemovable)
                            <a class="btn btn-sm btn-info" href="{{ route("{$prefix}_add") }}">@lang('admin.addNew')</a>
                        @endif
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="@lang('admin.tooltips.close')"><i class="fa fa-times"></i></button>
                    </div>
                    @if($listTranslatable)
                        <ul class="nav nav-tabs">
                            @foreach($languages as $language)
                                <li {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'class=active' : '' }}>
                                    <a data-toggle="tab" href="#{{ $language['locale'] }}">{{ $language['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="box-body">
                    <div class="panel-group">
                        @yield('items')
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <script>
        var token = '{{ csrf_token() }}';

        function swap(id1, id2, route) {
            route = undefined === route ? '{{ route("{$prefix}_swap")}}' : route;
            $.ajax({
                type: 'POST',
                url: route,
                data: {_token: token, ids: [id1, id2]},
                success: function (response) {
                    if(JSON.parse(response).success !== true)
                        alert('Moving failed! ' + (response.message ? response.message : ''));
                    else window.location.reload();
                }
            });
        }

        function remove(id, panel, route) {
            if (!confirm('Delete?')) return;
            route = undefined === route ? '{{ route("{$prefix}_remove")}}' : route;
            $.ajax({
                type: 'POST',
                url: route,
                data: {_token: token, id: id},
                success: function (response) {
                    if(JSON.parse(response).success !== true)
                        alert('Removing failed! ' + (response.message ? response.message : ''));
                    else {
                        if (typeof panel !== 'undefined') panel.fadeOut(200);
                        else window.location.reload();
                    }
                }
            });
        }

        function toggleDisabled(id, that, route) {
            that = $(that);
            route = undefined === route ? '{{ route("{$prefix}_toggleDisabled")}}' : route;
            $.ajax({
                type: 'POST',
                url: route,
                data: {_token: token, id: id},
                success: function (response) {
                    if(JSON.parse(response).success !== true) {
                        alert(that.data('title')+' failed! ' + (response.message ? response.message : ''));
                    }
                    else {
                        response = JSON.parse(response);
                        var newTitle = response.disabled === true ? '<?=trans('admin.tooltips.enable')?>' : '<?=trans('admin.tooltips.disable')?>';
                        var newColor = response.disabled ? '#333':'#00f8ff';
                        that.attr('title', newTitle).tooltip('fixTitle').tooltip('show');
                        that.css('color', newColor);
                    }
                }
            });
        }
    </script>
@endsection
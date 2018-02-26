@extends('admin.layout')

@section('content')
    <div class='row'>
        <div class='col-md-10'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $pageTitle }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="@lang('admin.tooltips.close')"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-group">
                        @if(!empty($items))
                            <div class="tab-content">
                                @foreach($items as $item)
                                    <div class="panel panel-default hidden-icons-container" data-item-id="{{ $item['pathname'] }}">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-4"><img src="{{ asset($item['pathname']) }}" width="150px" style="border: 1px solid #c8c8c8"/></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>@lang('admin.pages.images.name'): </b>{{ $item['filename'] }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>@lang('admin.pages.images.size'): </b>{{ number_format($item['size']/1000, 2) }} KB</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>@lang('admin.pages.images.path'): </b>{{ $item['pathname'] }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>@lang('admin.pages.images.createdAt'): </b>{{ date('d-m-Y H:i:s', $item['cTime']) }}</div>
                                            </div>
                                            @if($item['parentModel'])
                                                <div class="row">
                                                    <div class="col-md-6"><b>@lang('admin.pages.images.usedIn'): </b>{{ trans("admin.sidebar.$item[parentModel]") }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="hidden-icons">
                                            <i class="fa fa-times" data-toggle="tooltip" data-title="@lang('admin.tooltips.remove')" onclick="remove('{{ $item['pathname'] }}', $(this).closest('.panel'))" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            @lang('admin.noItemsFound')
                        @endif
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <script>
        function remove(id, panel) {
            if (!confirm('Delete?')) return;
            var token = '{{ csrf_token() }}';
            $.ajax({
                type: 'POST',
                url: '{{ route("images_remove")}}',
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
    </script>
@endsection

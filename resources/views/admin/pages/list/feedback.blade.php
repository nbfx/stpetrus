@extends('admin.layout')

@section('content')
    <div class='row'>
        <div class='col-md-6'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.pages.titles.list.feedback.new')</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="@lang('admin.tooltips.close')"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-group" id="accordion-new">
                        @if(!empty($data['new']))
                            @foreach($data['new'] as $item)
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion-new" href="#new-{{ $item['id'] }}">
                                                <div class="pull-left">
                                                    {{ "$item[first_name] $item[last_name]".($item['people_amount'] ? ", ".trans_choice('admin.pages.text.people', $item['people_amount'], ['amount' => $item['people_amount']]) : '')}}
                                                </div>
                                                <span class="pull-right label label-info">{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</span>
                                                <div class="clearfix"></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="new-{{ $item['id'] }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <p><b>@lang('admin.pages.fields.phone'): </b>{{ $item['phone'] }}</p>
                                                    <p><b>@lang('admin.pages.fields.email'): </b><a href="mailto:{{$item['email']}}">{{ $item['email'] }}</a></p>
                                                    <p><b>@lang('admin.pages.fields.reserve_date'): </b>{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.feedback_date'): </b>{{ date('H:i d.m.y', strtotime($item['created_at'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.last_update'): </b>{{ date('H:i d.m.y', strtotime($item['updated_at'])) }}</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p><b>@lang('admin.pages.fields.feedback_description'): </b>{{ $item['description'] }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            @include('admin.parts.statusButtons', ['id' => $item['id'], 'currentStatus' => $item['status']])
                                            <a class="btn btn-default pull-right" onclick="remove('{{ $item['id'] }}', $(this).closest('.panel'))"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><!-- /.box -->
        </div>

        <div class="col-md-6">
            <!-- Box -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.pages.titles.list.feedback.seen')</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="@lang('admin.tooltips.close')"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-group" id="accordion-seen">
                        @if(!empty($data['seen']))
                            @foreach($data['seen'] as $item)
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion-seen" href="#seen-{{ $item['id'] }}">
                                                <div class="pull-left">
                                                    {{ "$item[first_name] $item[last_name]".($item['people_amount'] ? ", ".trans_choice('admin.pages.text.people', $item['people_amount'], ['amount' => $item['people_amount']]) : '')}}
                                                </div>
                                                <span class="pull-right label label-info">{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</span>
                                                <div class="clearfix"></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="seen-{{ $item['id'] }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <p><b>@lang('admin.pages.fields.phone'): </b>{{ $item['phone'] }}</p>
                                                    <p><b>@lang('admin.pages.fields.email'): </b><a href="mailto:{{$item['email']}}">{{ $item['email'] }}</a></p>
                                                    <p><b>@lang('admin.pages.fields.reserve_date'): </b>{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.feedback_date'): </b>{{ date('H:i d.m.y', strtotime($item['created_at'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.last_update'): </b>{{ date('H:i d.m.y', strtotime($item['updated_at'])) }}</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p><b>@lang('admin.pages.fields.feedback_description'): </b>{{ $item['description'] }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            @include('admin.parts.statusButtons', ['id' => $item['id'], 'currentStatus' => $item['status']])
                                            <a class="btn btn-default pull-right" onclick="remove('{{ $item['id'] }}', $(this).closest('.panel'))"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- Box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.pages.titles.list.feedback.accepted')</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="@lang('admin.tooltips.close')"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-group" id="accordion-accepted">
                        @if(!empty($data['accepted']))
                            @foreach($data['accepted'] as $item)
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion-accepted" href="#accepted-{{ $item['id'] }}">
                                                <div class="pull-left">
                                                    {{ "$item[first_name] $item[last_name]".($item['people_amount'] ? ", ".trans_choice('admin.pages.text.people', $item['people_amount'], ['amount' => $item['people_amount']]) : '')}}
                                                </div>
                                                <span class="pull-right label label-info">{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</span>
                                                <div class="clearfix"></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="accepted-{{ $item['id'] }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <p><b>@lang('admin.pages.fields.phone'): </b>{{ $item['phone'] }}</p>
                                                    <p><b>@lang('admin.pages.fields.email'): </b><a href="mailto:{{$item['email']}}">{{ $item['email'] }}</a></p>
                                                    <p><b>@lang('admin.pages.fields.reserve_date'): </b>{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.feedback_date'): </b>{{ date('H:i d.m.y', strtotime($item['created_at'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.last_update'): </b>{{ date('H:i d.m.y', strtotime($item['updated_at'])) }}</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p><b>@lang('admin.pages.fields.feedback_description'): </b>{{ $item['description'] }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            @include('admin.parts.statusButtons', ['id' => $item['id'], 'currentStatus' => $item['status']])
                                            <a class="btn btn-default pull-right" onclick="remove('{{ $item['id'] }}', $(this).closest('.panel'))"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
        <div class="col-md-6">
            <!-- Box -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.pages.titles.list.feedback.denied')</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="@lang('admin.tooltips.close')"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="panel-group" id="accordion-denied">
                        @if(!empty($data['denied']))
                            @foreach($data['denied'] as $item)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion-denied" href="#denied-{{ $item['id'] }}">
                                                <div class="pull-left">
                                                    {{ "$item[first_name] $item[last_name]".($item['people_amount'] ? ", ".trans_choice('admin.pages.text.people', $item['people_amount'], ['amount' => $item['people_amount']]) : '')}}
                                                </div>
                                                <span class="pull-right label label-info">{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</span>
                                                <div class="clearfix"></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="denied-{{ $item['id'] }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <p><b>@lang('admin.pages.fields.phone'): </b>{{ $item['phone'] }}</p>
                                                    <p><b>@lang('admin.pages.fields.email'): </b><a href="mailto:{{$item['email']}}">{{ $item['email'] }}</a></p>
                                                    <p><b>@lang('admin.pages.fields.reserve_date'): </b>{{ date('H:i d.m.y', strtotime($item['date_time'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.feedback_date'): </b>{{ date('H:i d.m.y', strtotime($item['created_at'])) }}</p>
                                                    <p><b>@lang('admin.pages.fields.last_update'): </b>{{ date('H:i d.m.y', strtotime($item['updated_at'])) }}</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p><b>@lang('admin.pages.fields.feedback_description'): </b>{{ $item['description'] }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            @include('admin.parts.statusButtons', ['id' => $item['id'], 'currentStatus' => $item['status']])
                                            <a class="btn btn-default pull-right" onclick="remove('{{ $item['id'] }}', $(this).closest('.panel'))"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
    <script type="text/javascript">
        var token = '{{ csrf_token() }}';

        function changeStatus(id, newStatus) {
            $.ajax({
                type: 'POST',
                url: '{{ route('feedback_changeStatus') }}',
                data: {_token: token, id: id, status: newStatus},
                success: function (response) {
                    if(JSON.parse(response).success !== true)
                        alert('Changing status failed! ' + (response.message ? response.message : ''));
                    else window.location.reload();
                }
            });
        }

        function remove(id, item) {
            $.ajax({
                type: 'POST',
                url: '{{ route('feedback_remove') }}',
                data: {_token: token, id: id},
                success: function (response) {
                    response = JSON.parse(response);
                    if(response.success !== undefined && response.success === true)
                        item.fadeOut();
                    else alert('Removing failed!');
                }
            });
        }
    </script>
@endsection
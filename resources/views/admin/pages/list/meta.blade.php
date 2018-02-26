@extends('admin.pages.list')

@section('items')
    @if(!empty($items))
        @foreach($items as $index => $item)
            <div class="panel panel-default hidden-icons-container" data-item-id="{{ $item['id'] }}">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1">
                            <b>@lang('admin.pages.fields.name'):</b>
                        </div>
                        <div class="col-md-1">
                            {{ $item['name'] }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <b>@lang('admin.pages.fields.content'):</b>
                        </div>
                        <div class="col-md-11">
                            {{ $item['content'] }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 html-code">&lt;meta <span class="html-attribute-name">@lang('admin.pages.fields.name')</span>="<span class="html-attribute-value">{{ $item['name'] }}</span>" <span class="html-attribute-name">@lang('admin.pages.fields.content')</span>="<span class="html-attribute-value">{{ $item['content'] }}</span>"&gt;</div>
                    </div>
                    @include('admin.parts.controlIcons')
                </div>
            </div>
        @endforeach
    @else
        @lang('admin.noItemsFound')
    @endif
@endsection
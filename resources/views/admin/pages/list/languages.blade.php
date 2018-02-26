@extends('admin.pages.list')

@section('items')
    @if(!empty($items))
        @foreach($items as $index => $item)
            <div class="panel panel-default hidden-icons-container" data-item-id="{{ $item['id'] }}">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1"><b>@lang('admin.pages.fields.language'): </b></div><div class="col-md-4">{{ $item['title'] }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"><b>@lang('admin.pages.fields.locale'): </b></div><div class="col-md-4">{{ $item['locale'] }}</div>
                    </div>
                    @if($item['description'])
                        <div class="row">
                            <div class="col-md-1"><b>@lang('admin.pages.fields.description'): </b></div><div class="col-md-4">{{ $item['description'] }}</div>
                        </div>
                    @endif
                    @include('admin.parts.controlIcons')
                </div>
            </div>
        @endforeach
    @else
        @lang('admin.noItemsFound')
    @endif
@endsection
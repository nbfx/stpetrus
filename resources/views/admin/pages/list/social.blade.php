@extends('admin.pages.list')

@section('items')
    @if(!empty($items))
        <div class="tab-content">
            @foreach($languages as $language)
                <div id="{{ $language['locale'] }}" class="tab-pane fade {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'in active' : '' }}">
                    @foreach($items as $index => $item)
                        <? $suffix = $language['locale'] == config('app.fallback_locale') ? '' : "_$language[locale]"; ?>
                        <div class="panel panel-info hidden-icons-container" data-item-id="{{ $item['id'] }}">
                            <div class="panel-heading">
                                <h4>
                                    {{ $item["title$suffix"] ?? "({$languages[0]['title']}) $item[title]" }}
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class='row'>
                                    <div class="col-md-5">
                                        <b>@lang('admin.pages.fields.image'): </b><img src="{{ asset($item['image']) }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-11">
                                        <b>@lang('admin.pages.fields.url'):</b> <a target="_blank" href="{{ $item['url'] }}">{{ $item['url'] }}</a>
                                    </div>
                                </div>
                                @include('admin.parts.controlIcons')
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else

    {{--@if(!empty($items))
        @foreach($items as $index => $item)
            <div class="panel panel-info hidden-icons-container" data-item-id="{{ $item['id'] }}">
                <div class="panel-heading">
                    <h4>
                        {{ $item['title'] }}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1"><b>@lang('admin.pages.fields.image'): </b></div><div class="col-md-4"><img src="{{ asset($item['image']) }}"/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"><b>@lang('admin.pages.fields.url'): </b></div><div class="col-md-4">{{ $item['url'] }}</div>
                    </div>
                    @include('admin.parts.controlIcons')
                </div>
            </div>
        @endforeach
    @else--}}
        @lang('admin.noItemsFound')
    @endif
@endsection
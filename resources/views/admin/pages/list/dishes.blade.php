@extends('admin.pages.list')

@section('items')
    @if(!empty($items))
        <div class="tab-content">
            @foreach($languages as $language)
                <div id="{{ $language['locale'] }}" class="tab-pane fade {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'in active' : '' }}">
                    @foreach($items as $index => $item)
                        <? $suffix = $language['locale'] == config('app.fallback_locale') ? '' : "_$language[locale]"; ?>
                        <div class="panel panel-default hidden-icons-container" data-item-id="{{ $item['id'] }}">
                            <div class="panel-heading"><h4>{{ $item["title$suffix"] ?? "({$languages[0]['title']}) $item[title]" }}</h4></div>
                            <div class="panel-body">
                                <div class='row'>
                                    <div class="col-md-5">
                                        <img src="{{ asset($item['image']) }}" width="400px"/>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="well">{{ $item["description$suffix"] ?? "({$languages[0]['title']}) $item[description]" }}</div>
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
        @lang('admin.noItemsFound')
    @endif
@endsection
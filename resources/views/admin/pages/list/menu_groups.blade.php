@extends('admin.pages.list')

@section('items')
    @if(!empty($items))
        <div class="tab-content">

            @foreach($languages as $language)
                <? $suffix = $language['locale'] == config('app.fallback_locale') ? '' : "_$language[locale]"; ?>
                <div id="{{ $language['locale'] }}" class="tab-pane fade {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'in active' : '' }}">
                    @foreach($items as $index => $item)
                        <div class="panel panel-default">
                            <div class="panel-heading hidden-icons-container">
                                <a data-toggle="collapse" href="#{{ "$item[name]$suffix" }}">
                                    <h4 class="panel-title">{{ $item["title$suffix"] ?? "({$languages[0]['title']}) $item[title]" }}</h4>
                                    <small class="form-text text-muted field-editable" data-field="description">{{ $item["description$suffix"] ?? ($item['description'] ? "({$languages[0]['title']}) $item[description]" : '') }}</small>
                                </a>
                                @include('admin.parts.controlIcons')
                            </div>
                            <div id="{{ "$item[name]$suffix" }}" class="panel-collapse collapse" style="padding: 10px">
                                <div class='row'>
                                    <div class="col-md-5">
                                        <img src="{{ asset($item['image']) }}" width="400px"/>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="well field-editable" data-field="text">
                                            <img src="{{ asset($item['preview_image']) }}" width="150px"/>
                                            {{ $item["description$suffix"] ?? "({$languages[0]['title']}) $item[description]" }}
                                        </div>
                                    </div>
                                </div>
                                <h4 class="text-center">@lang('admin.pages.titles.items')</h4>
                                <ul class="list-group">
                                    @if(!empty($item['children']))
                                        @foreach($item['children'] as $childIndex => $child)
                                            <li class="list-group-item hidden-icons-container panel">
                                                &nbsp;&nbsp;{{ $child["title$suffix"] ?? "({$languages[0]['title']}) $child[title]" }} / {{ config('app.currency').$child['price'] }}<br/>
                                                &nbsp;&nbsp;<small class="form-text text-muted field-editable" data-field="description">{{ $child["description$suffix"] ?? ($child['description'] ? "({$languages[0]['title']}) $child[description]" : '') }}</small>
                                                @include('admin.parts.controlIcons', ['index' => $childIndex, 'items' => $item['children'], 'item' => $child, 'prefix' => 'menu_items'])
                                            </li>
                                        @endforeach
                                    @endif
                                    <li class="list-group-item">&nbsp;&nbsp;<a href="{{ route('menu_items_add', ['parent' => $item['id']]) }}" class="add-child">@lang('admin.add')</a></li>
                                </ul>
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

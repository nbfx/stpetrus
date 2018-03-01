@extends('admin.pages.list')

@section('items')
    @if(!empty($items))
        <div class="tab-content">

            @foreach($languages as $language)
                <? $suffix = $language['locale'] == config('app.fallback_locale') ? '' : "_$language[locale]"; ?>
                <div id="{{ $language['locale'] }}" class="tab-pane fade {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'in active' : '' }}">
                    @foreach($items as $index => $item)
                        <div class="panel panel-info">
                            <div class="panel-heading hidden-icons-container">
                                <a data-toggle="collapse" href="#{{ "$item[name]$suffix" }}">
                                    <h4 class="panel-title">{{ $item["title$suffix"] ?? "({$languages[0]['title']}) $item[title]" }}</h4>
                                    <small class="form-text text-muted field-editable" data-field="description">{{ $item["description$suffix"] ?? ($item['description'] ? "({$languages[0]['title']}) $item[description]" : '') }}</small>
                                </a>
                                @include('admin.parts.controlIcons')
                            </div>
                            <div id="{{ "$item[name]$suffix" }}" class="panel-collapse collapse" style="padding: 10px">
                                <div class='row'>
                                    <div class="col-md-12">
                                    @if(!empty($item['children']))
                                        @foreach($item['children'] as $childIndex => $child)

                                            <div class="panel panel-default">
                                                <div class="panel-heading hidden-icons-container">
                                                    <a data-toggle="collapse" href="#{{ "$child[name]$suffix" }}">
                                                        <h4 class="panel-title">{{ $child["title$suffix"] ?? "({$languages[0]['title']}) $child[title]" }}</h4>
                                                        <small class="form-text text-muted field-editable" data-field="description">{{ $child["description$suffix"] ?? ($child['description'] ? "({$languages[0]['title']}) $child[description]" : '') }}</small>
                                                    </a>
                                                    @include('admin.parts.controlIcons', ['index' => $childIndex, 'items' => $item['children'], 'item' => $child, 'prefix' => 'drink_groups'])
                                                </div>
                                                <div id="{{ "$child[name]$suffix" }}" class="panel-collapse collapse" style="padding: 5px">
                                                    <h4 class="text-center">@lang('admin.pages.titles.items')</h4>
                                                    <ul class="list-group">
                                                        @if(!empty($child['children']))
                                                            @foreach($child['children'] as $childItemIndex => $childItem)
                                                                <li class="list-group-item hidden-icons-container panel">
                                                                    &nbsp;&nbsp;{{ $childItem["title$suffix"] ?? "({$languages[0]['title']}) $childItem[title]" }} / {{ config('app.currency').$childItem['price'] }}<br/>
                                                                    &nbsp;&nbsp;<small class="form-text text-muted field-editable" data-field="description">{{ $child["description$suffix"] ?? ($childItem['description'] ? "({$languages[0]['title']}) $childItem[description]" : '') }}</small>
                                                                    @include('admin.parts.controlIcons', ['index' => $childItemIndex, 'items' => $child['children'], 'item' => $childItem, 'prefix' => 'drink_items'])
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                    &nbsp;&nbsp;<a href="{{ route('drink_items_add', ['parent' => $child['id']]) }}" class="add-child">@lang('admin.add')</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                                <hr>
                                &nbsp;&nbsp;<a href="{{ route('drink_groups_add', ['parent' => $item['id']]) }}" class="add-child btn btn-default">@lang('admin.add')</a>
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

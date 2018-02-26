@extends('admin.layout')

@section('content')
    <div class='row'>
        <div class='col-md-8'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $pageTitle }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="@lang('admin.tooltips.collapse')">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <ul class="nav nav-tabs">
                        @foreach($languages as $language)
                            <li {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'class=active' : '' }}>
                                <a data-toggle="tab" href="#{{ $language['locale'] }}">{{ $language['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="box-body">
                    <form class="form-horizontal tab-content" role="form" method="POST"
                          action="{{ route("{$prefix}_save") }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" value="{{ $oldData['id'] }}" name="id">

                        @foreach($languages as $language)
                            <div id="{{ $language['locale'] }}" class="tab-pane fade {{ $language['locale'] == config('app.locale') || !in_array(config('app.locale'), collect($languages)->pluck('locale')->toArray()) && $language['locale'] == config('app.fallback_locale') ? 'in active' : '' }}">
                                @foreach($fields as $field => $params)
                                    @if(in_array($field, $translatableFields) && $field .= $language['locale'] == config('app.fallback_locale') ? '' : "_$language[locale]")
                                        <div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
                                            <label for="{{ $field }}"
                                                   class="col-md-2 control-label">{{ $params['label'].' ('.$language['title'].')' }}</label>
                                            <div class="col-md-10 margin-bottom-10">
                                                @if($params['type'] == 'textarea')
                                                    <textarea id="{{ $field }}" class="form-control" name="{{ $field }}"
                                                            {{ $params['required'] && $language['locale'] == config('app.fallback_locale') ? 'required=required' : '' }}
                                                            {{ !empty($params['helpText']) ? "aria-describedby={$field}Help" : '' }}>{{ $oldData[$field] ?? '' }}</textarea>
                                                @elseif($params['type'] == 'input')
                                                    <input id="{{ $field }}" type="{{ $params['inputType'] }}"
                                                           class="form-control{{ $params['inputType'] == 'file' ? '-file' : '' }}"
                                                           name="{{ $field }}" value="{{ $oldData[$field] ?? '' }}"
                                                            {{ $params['required'] && $language['locale'] == config('app.fallback_locale') ? 'required=required' : '' }}>
                                                @endif
                                                @if(!empty($params['helpText']))
                                                    <small id="{{ $field }}Help"
                                                           class="form-text text-muted">{{ $params['helpText'] }}</small>
                                                @endif
                                                @if ($errors->has($field))
                                                    <span class="help-block"><strong>{{ $errors->first($field) }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                        @foreach($fields as $field => $params)
                            @if(!in_array($field, $translatableFields))
                                <div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
                                    <label for="{{ $field }}"
                                           class="col-md-2 control-label">{{ $params['label'] }}</label>
                                    <div class="col-md-10 margin-bottom-10">
                                        @if($params['type'] == 'textarea')
                                            <textarea id="{{ $field }}" class="form-control" name="{{ $field }}"
                                                    {{ $params['required'] ? 'required=required' : '' }}
                                                    {{ !empty($params['helpText']) ? "aria-describedby={$field}Help" : '' }}>{{ $oldData[$field] ?? '' }}</textarea>
                                        @elseif($params['type'] == 'input')
                                            @if($params['inputType'] == 'file')
                                                <img id="{{ "preview_$field" }}" src="{{ asset($oldData[$field]) }}" width="200px"/>
                                                <div class="fileUpload btn btn-primary">
                                                    <span>@lang('admin.pages.fields.addImage')</span>
                                                    <input id="{{ $field }}" type="file" class="upload" name="{{ $field }}" />
                                                </div>
                                            @else
                                                <input id="{{ $field }}" type="{{ $params['inputType'] }}"
                                                       class="{{ $params['inputType'] == 'checkbox' ? '' : 'form-control' }}"
                                                       name="{{ $field }}" {{ $oldData[$field] ? 'value='.$oldData[$field].'' : '' }}
                                                        {{ $params['required'] ? 'required=required' : '' }}>
                                            @endif
                                        @endif
                                        @if(!empty($params['helpText']))
                                            <small id="{{ $field }}Help"
                                                   class="form-text text-muted">{{ $params['helpText'] }}</small>
                                        @endif
                                        @if ($errors->has($field))
                                            <span class="help-block"><strong>{{ $errors->first($field) }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <input type="hidden" value="{{ $oldData['order'] }}" name="order">

                        @if($isParentable)
                            <? // Convert array to collection
                            $items = collect($items) ?>
                            <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                                <label for="parent" class="col-md-2 control-label">@lang('admin.pages.fields.parent')</label>
                                <div class="col-md-10 margin-bottom-10">
                                    <select id="parent" class="form-control selectpicker" name="parent">
                                        @if($items->count())
                                            <? $parent = request()->get('parent') ? request()->get('parent') : ($oldData['parent'] ?? false) ?>
                                            @foreach($items as $index => $item)
                                                @if(empty($item['parent']) || $item['parent'] == null)
                                                    <option {{ $parent && $item['id'] == $parent ? 'selected="selected"' : '' }} value="{{ $item['id'] }}">{{ $item['title'] }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('order'))
                                        <span class="help-block"><strong>{{ $errors->first('order') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">
                                    @lang('admin.save')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <script>
        var token = '{{ csrf_token() }}';

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview_'+input.id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("input[type=file]").change(function(){
            readURL(this);
        });

        $('button[type=submit]').click(function (e) {
            var form = e.target.form;
            e.preventDefault();
            var url = '{{ route("{$prefix}_validate") }}';
            var form_data = {_token: token};
                <?php $fieldsToValidate = []; foreach ($fields as $field => $params) if ($params['required']) $fieldsToValidate[] = $field;?>
            var fieldsToValidate = <?='["'.implode('", "', $fieldsToValidate).'"]'?>;
            $.each(fieldsToValidate, function( index, value ) {
                var field = $('[name='+value+']');
                form_data[value] = value != 'image' && value != 'preview_image' ? field.val() : (field[0].files ? (field[0].files[0] == undefined ? '' : field[0].files[0].name) : '');
            });
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.success == true) {
                        form.submit();
                    } else {
                        $.each(response.errors, function (field, message) {
                            if (field == 'image' || field == 'preview_image') {
                                $('[name='+field+']').on('click', function () {
                                    $(this).parent().tooltip('disable').removeClass('btn-danger');
                                }).parent().attr('title', message).tooltip('fixTitle').tooltip('show').addClass('btn-danger');
                            } else {
                                $('[name='+field+']').on('input change', function () {
                                    $(this).tooltip('disable').parent().removeClass('has-error');
                                }).attr('title', message).tooltip('fixTitle').tooltip('show').parent().addClass('has-error');
                            }
                        });
                    }
                },
            });
        });
    </script>
@endsection
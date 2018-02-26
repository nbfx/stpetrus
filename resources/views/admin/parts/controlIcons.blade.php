<span class="hidden-icons">
    @if($isOrderable)
        @if($index > 0)
            <i class="fa fa-arrow-up" data-toggle="tooltip" data-title="@lang('admin.tooltips.moveUp')" onclick="swap('{{ $item['id'] }}', '{{ $items[$index - 1]['id'] }}', '{{route($prefix.'_swap')}}')" aria-hidden="true"></i>
        @endif
        @if($index < count($items) - 1)
            <i class="fa fa-arrow-down" data-toggle="tooltip" data-title="@lang('admin.tooltips.moveDown')" onclick="swap('{{ $item['id'] }}', '{{ $items[$index + 1]['id'] }}', '{{route($prefix.'_swap')}}')" aria-hidden="true"></i>
        @endif
    @endif
    @if($isEditable)
        <i class="fa fa-pencil" data-toggle="tooltip" data-title="@lang('admin.tooltips.edit')" onclick="window.location.href = '{{ route("{$prefix}_edit", ['id' => $item['id']]) }}'" aria-hidden="true"></i>
    @endif
    <i class="fa fa-power-off" style="color:{{$item['disabled']?'#333':'#00f8ff'}}" data-toggle="tooltip" data-title="@lang('admin.tooltips.'.($item['disabled'] ? 'enable' : 'disable'))" onclick="toggleDisabled('{{ $item['id'] }}', this, '{{route($prefix.'_toggleDisabled')}}')" aria-hidden="true"></i>
    @if($isRemovable)
        <i class="fa fa-times" data-toggle="tooltip" data-title="@lang('admin.tooltips.remove')" onclick="remove('{{ $item['id'] }}', $(this).closest('.panel'), '{{route($prefix.'_remove')}}')" aria-hidden="true"></i>
    @endif
</span>
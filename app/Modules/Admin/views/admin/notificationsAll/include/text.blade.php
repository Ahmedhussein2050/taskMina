

<label class="check-task all_{{ $item->id }} {{ $item->read_at == null ? '' : 'done-task' }} ">
    <input type="checkbox" name="ckeckedAll" class="notify" value="{{ $item->id }}"
        {{ $item->read_at == null ? '' : 'checked' }}>
    <span class="cr">
        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
    </span>
    @if (isset($item->data['title']))
        <span class="task-title-sp">{{ $item->data['title'] }}</span>
    @elseif (isset($item->data['orderText']))
        @if (@isset($item->data['orderText'][get_lang_code()]))
            <span class="task-title-sp">{{ $item->data['name'][get_lang_code()] }}</span>
        @endif
    @elseif (isset($item->data['name']))
        @if (@isset($item->data['name'][get_lang_code()]))
            <span class="task-title-sp">{{ $item->data['name'][get_lang_code()] }}</span>
        @endif
    @endif
    @if (isset($item->data['order_id']))
        <a href="{{ url('admin/orders/' . $item->data['order_id'] . '/show') }}">{{ _i('Go') }}..</a>

    @elseif (isset($item->data['product_id']))

        <a href="{{ url('admin/products?prod=' . $item->data['product_id']) }}">{{ _i('Product Added') }}..</a>
    @elseif (isset($item->data['id']))

        <a href="{{ url('admin/products?prod=' . $item->data['id']) }}">{{ _i('Show') }}..</a>
    @elseif (isset($item->data['order_url']))
        <a href="{{ $item->data['order_url'] }}">{{ _i('Go') }}..</a>
    @elseif (isset($item->data['url']))
        <a href="{{ $item->data['url'] }}">{{ _i('Go') }}..</a>
    @endif
    <div class="f-right hidden-phone">
        <a href="{{ route('notificationAll.destroy', $item->id) }}">
            <i class="icofont icofont-ui-delete delete_todo" data-id="{{ $item->id }}"
                data-remote="{{ route('notificationAll.destroy', $item->id) }}"></i>
        </a>
    </div>
</label>
@php
//print_r($item->data);
@endphp

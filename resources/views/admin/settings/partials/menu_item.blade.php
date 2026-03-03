@php
    $uniqueId = ($prefix ?? 'menu') . '_' . Str::random(8);
@endphp
<li class="wp-menu-item mb-2" data-label="{{ $item['label'] ?? '' }}" data-url="{{ $item['url'] ?? '' }}" data-new-tab="{{ !empty($item['new_tab']) ? '1' : '0' }}">
    <div class="wp-menu-item-handle d-flex align-items-center justify-content-between p-2 bg-white border rounded shadow-sm" style="cursor: move;">
        <div class="d-flex align-items-center">
            <i class="fas fa-arrows-alt text-muted mr-2 handle-icon"></i>
            <span class="menu-item-title font-weight-bold small">{{ $item['label'] ?? __('Menu Item') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge badge-light text-muted border mr-2 small font-weight-normal">{{ !empty($item['children']) ? __('Nested') : '' }}</span>
            <button type="button" class="btn btn-xs btn-link p-0 text-dark toggle-menu-details">
                <i class="fas fa-chevron-down transition-icon"></i>
            </button>
        </div>
    </div>
    
    <div class="wp-menu-item-details bg-white border border-top-0 rounded-bottom p-3 shadow-sm" style="display: none;">
        <div class="form-group mb-2">
            <label class="small mb-1">{{ __('Navigation Label') }}</label>
            <input type="text" class="form-control form-control-sm edit-menu-label" value="{{ $item['label'] ?? '' }}">
        </div>
        <div class="form-group mb-2">
            <label class="small mb-1">{{ __('URL') }}</label>
            <input type="text" class="form-control form-control-sm edit-menu-url" value="{{ $item['url'] ?? '' }}">
        </div>
        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input edit-menu-new-tab" id="tab-{{ $uniqueId }}" {{ !empty($item['new_tab']) ? 'checked' : '' }}>
            <label class="custom-control-label small font-weight-normal" for="tab-{{ $uniqueId }}">{{ __('Open link in a new tab') }}</label>
        </div>
        <div class="d-flex justify-content-between border-top pt-2">
            <button type="button" class="btn btn-xs btn-link text-danger p-0 remove-menu-item">{{ __('Remove') }}</button>
            <button type="button" class="btn btn-xs btn-link text-primary p-0 toggle-menu-details">{{ __('Cancel') }}</button>
        </div>
    </div>

    @if(!($no_nesting ?? false))
    <ul class="wp-menu-list sortable-list mt-2 ml-4">
        @if(!empty($item['children']))
            @foreach($item['children'] as $child)
                @include('admin.settings.partials.menu_item', ['item' => $child, 'prefix' => $prefix, 'is_child' => true])
            @endforeach
        @endif
    </ul>
    @endif
</li>

@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', ['name' => __('rules.admin.list.header')]),
])

@push('header')
    @at(mm('Rules', 'Resources/assets/styles/admin/sortable.scss'))
@endpush

@push('content')
    <div class="admin-header d-flex justify-content-between align-items-center">
        <div>
            <h2>@t('rules.admin.header')</h2>
            <p>@t('rules.admin.description')</p>
        </div>
        <div>
            <a href="{{ url('admin/rules/add') }}" class="btn size-s outline">
                @t('rules.admin.list.add')
            </a>
        </div>
    </div>

    @if(sizeof($list) > 0)
        <ul class="sortable-group rules-list-nav-nested-sortable">
            @foreach($list as $item)
                <li class="sortable-item sortable-dropdown draggable" data-id="{{ $item->id }}" id="{{ $item->id }}"
                    style="">
                    <div class="rules-sortable">
                        <div class="rules-body d-flex justify-content-between">
                            <span class="sortable-text">
                                <i class="ph ph-arrows-out-cardinal sortable-handle"></i>
                                <span class="badge">{{ __($item->rule) }}</span>
                            </span>

                            <div class="rules-list-action sortable-buttons">
                                <a href="{{url('admin/rules/edit/' . $item->id) }}" class="change"
                                    data-tooltip="@t('def.edit')" data-tooltip-conf="left">
                                    <i class="ph ph-pencil"></i>
                                </a>
                                <div class="delete" data-deleteitem="{{ $item->id }}" data-tooltip="@t('def.delete')"
                                     data-tooltip-conf="left">
                                    <i class="ph ph-trash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <button id="saveRulesList" class="btn primary size-s mt-4">@t('def.save')</button>
    @else
        <div class="navigation_empty">
            @t('rules.admin.empty')
        </div>
    @endif
@endpush

@push('footer')
    <script src="https://SortableJS.github.io/Sortable/Sortable.js"></script>
    @at(mm('Rules', 'Resources/assets/js/admin/list.js'))
@endpush
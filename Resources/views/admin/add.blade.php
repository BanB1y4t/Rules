@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', ['name' => __('rules.admin.add.title')]),
])


@push('content')
    <div class="admin-header d-flex justify-content-between align-items-center">
        <div>
            <a class="back-btn" href="{{ url('admin/rules/list') }}">
                <i class="ph ph-arrow-left ignore"></i>
                @t('def.back')
            </a>
            <h2>@t('rules.admin.add.title')</h2>
            <p>@t('rules.admin.add.description')</p>
        </div>
    </div>

    <form data-form="add" data-page="rules">
        @csrf
        <!-- Поле для ввода названия правила -->
        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="rule_name">
                    @t('rules.admin.add.name_rule')
                </label>
            </div>
            <div class="col-sm-9">
                <input name="rule" id="rule" placeholder="@t('rules.admin.add.rule')" type="text" class="form-control" required="">
            </div>
        </div>

        <!-- Поле редактора блока правила -->
        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label">
                <label for="blocks">@t('rules.admin.add.content_rule')</label>
            </div>
            <div class="col-sm-9">
                <div data-editorjs id="editorRulesAdd"></div>
            </div>
        </div>


        <!-- Кнопка отправки -->
        <div class="position-relative row form-check">
            <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn size-m btn--with-icon primary">
                    @t('def.save')
                    <span class="btn__icon arrow"><i class="ph ph-arrow-right"></i></span>
                </button>
            </div>
        </div>
    </form>
@endpush

@push('footer')
    <script>
        var rulesItemBlocks = {!! json_encode($blocks) !!};
    </script>
    <script src="@asset('assets/js/editor/table.js')"></script>
    <script src="@asset('assets/js/editor/alignment.js')"></script>
    <script src="@asset('assets/js/editor/raw.js')"></script>
    <script src="@asset('assets/js/editor/delimiter.js')"></script>
    <script src="@asset('assets/js/editor/embed.js')"></script>
    <script src="@asset('assets/js/editor/header.js')"></script>
    <script src="@asset('assets/js/editor/image.js')"></script>
    <script src="@asset('assets/js/editor/list.js')"></script>
    <script src="@asset('assets/js/editor/marker.js')"></script>


    <script src="@asset('assets/js/editor.js')"></script>

    @at('Core/Admin/Http/Views/assets/js/editor.js')
    @at(mm('Rules', 'Resources/assets/js/admin/add.js'))
@endpush

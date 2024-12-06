@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', [
        'name' => __('rules.admin.edit.title', [
            'name' => $rules->rule,
        ]),
    ]),
])


@push('content')
    <div class="admin-header d-flex justify-content-between align-items-center">
        <div>
            <a class="back-btn" href="{{ url('admin/rules/list') }}">
                <i class="ph ph-arrow-left ignore"></i>
                @t('def.back')
            </a>
            <h2>@t('rules.admin.edit.title', [
                    'name' => $rules->rule
                ])</h2>
            <p>@t('rules.admin.edit.description')</p>
        </div>
    </div>

    <form data-form="edit" data-page="rules">
        @csrf
        <!-- Поле для ввода названия правила -->
        <input type="hidden" name="id" value="{{ $rules->id }}">
        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="rule_name">
                    @t('rules.admin.edit.name_rule')
                </label>
            </div>
            <div class="col-sm-9">
                <input name="rule" id="rule" placeholder="@t('rules.admin.edit.rule')" type="text" class="form-control"
                       value="{{ $rules->rule }}" required>
            </div>
        </div>

        <!-- Поле редактора блока правила -->
        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label">
                <label for="blocks">@t('rules.admin.edit.content_rule')</label>
            </div>
            <div class="col-sm-9">
                <div data-editorjs id="editorRulesEdit-{{ $rules->id }}"></div>
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
    <script data-loadevery>
        window.defaultEditorData["editorRulesEdit-{{ $rules->id }}"] = {
            blocks: {!! $rules->blocks->json ?? '[]' !!}
        };
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
    @at('Modules/Rules/Resources/assets/js/admin/form.js')
@endpush

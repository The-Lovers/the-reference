@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/service.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.service.edit') }}"
        :items="[
            ['label' => __('dashboard.sidebar.service.edit')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.service.edit') }}</h2>

            <form action="{{ route('services.update', $service->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $service->title) }}" required>
                            <label for="title">{{ __('forms.service.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="1" {{ old('is_active', (int) $service->is_active) == 1 ? 'selected' : '' }}>{{ __('forms.service.status.active') }}</option>
                                <option value="0" {{ old('is_active', (int) $service->is_active) == 0 ? 'selected' : '' }}>{{ __('forms.service.status.inactive') }}</option>
                            </select>
                            <label for="is_active">{{ __('forms.service.status.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="is_featured" name="is_featured" required>
                                <option value="0" {{ old('is_featured', (int) $service->is_featured) == 0 ? 'selected' : '' }}>{{ __('forms.service.featured.no') }}</option>
                                <option value="1" {{ old('is_featured', (int) $service->is_featured) == 1 ? 'selected' : '' }}>{{ __('forms.service.featured.yes') }}</option>
                            </select>
                            <label for="is_featured">{{ __('forms.service.featured.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">{{ __('forms.service.description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="col-md-12 my-4">
                        <div class="buttons">
                            <a href="{{ route('services.index') }}" class="btn secondary">{{ __('buttons.cancel') }}</a>
                            <button class="btn success" name="action" value="save">{{ __('buttons.confirm') }}</button>
                            <button class="btn third" name="action" value="continue">{{ __('buttons.save-continue') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_2')
    <script>
        CKEDITOR.replace('description', {
            toolbar: [
                { name: 'clipboard', items: ['Undo','Redo'] },
                { name: 'styles', items: ['Format','Font','FontSize'] },
                { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike'] },
                { name: 'colors', items: ['TextColor','BGColor'] },
                { name: 'paragraph', items: ['NumberedList','BulletedList','Outdent','Indent','Blockquote'] },
                { name: 'align', items: ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
                { name: 'insert', items: ['Image','Table','HorizontalRule','Link'] },
                { name: 'tools', items: ['Maximize'] }
            ]
        });
    </script>
@endsection

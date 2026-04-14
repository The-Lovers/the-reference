@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/destination.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.destination.edit') }}"
        :items="[
            ['label' => __('dashboard.sidebar.destination.edit')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.destination.edit') }}</h2>

            <form action="{{ route('destinations.update', $destination->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="label" name="label" value="{{ old('label', $destination->label) }}" required>
                            <label for="label">{{ __('forms.destination.label') }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="country_id" name="country_id" required>
                                @foreach ($countries as $country)
                                    <option
                                        value="{{ $country->id }}"
                                        {{ old('country_id', $destination->country_id) == $country->id ? 'selected' : '' }}
                                    >
                                        {{ $country->label_fr ?? $country->label_en }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="country_id">{{ __('forms.destination.country') }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="is_available" name="is_available" required>
                                <option value="1" {{ old('is_available', (int) $destination->is_available) == 1 ? 'selected' : '' }}>{{ __('forms.destination.availability.available') }}</option>
                                <option value="0" {{ old('is_available', (int) $destination->is_available) == 0 ? 'selected' : '' }}>{{ __('forms.destination.availability.unavailable') }}</option>
                            </select>
                            <label for="is_available">{{ __('forms.destination.availability.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">{{ __('forms.destination.description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $destination->description) }}</textarea>
                    </div>

                    <div class="col-md-12 my-4">
                        <div class="buttons">
                            <a href="{{ route('destinations.index') }}" class="btn secondary">{{ __('buttons.cancel') }}</a>
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

@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/testimony.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.testimony.new') }}"
        :items="[
            ['label' => __('dashboard.sidebar.testimony.create')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.testimony.create') }}</h2>

            <form action="{{ route('testimonies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}" required>
                            <label for="surname">Surname</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="number" min="1" max="5" class="form-control" id="note" name="note" value="{{ old('note') }}">
                            <label for="note">Note (1-5)</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                    </div>

                    <div class="col-md-12 my-4">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('testimonies.index') }}" class="btn secondary">{{ __('buttons.cancel') }}</a>
                            <button class="btn success" name="action" value="save">{{ __('buttons.save') }}</button>
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

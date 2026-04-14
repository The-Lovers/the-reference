@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/mission/create.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.mission.edit') }}"
        :items="[
            ['label' => __('dashboard.sidebar.mission.edit')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.mission.edit') }}</h2>

            <form action="{{ route('missions.update', $mission->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6 col-xs-12 mb-3">
                        <div class="form-floating">
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                required
                                value="{{ old('title', $mission->title) }}"
                            >
                            <label for="title">{{ __('forms.mission.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12 mb-3">
                        <label for="cover" class="form-label">{{ __('forms.mission.cover') }}</label>
                        <input type="file" class="form-control" id="cover" name="cover">
                        @if ($mission->cover)
                            <img src="{{ sec_asset($mission->cover) }}" alt="{{ $mission->title }}" class="img-fluid mt-2" style="max-height: 120px;">
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ old('status', (int) $mission->status) == 1 ? 'selected' : '' }}>{{ __('forms.mission.status.active') }}</option>
                                <option value="0" {{ old('status', (int) $mission->status) == 0 ? 'selected' : '' }}>{{ __('forms.mission.status.inactive') }}</option>
                            </select>
                            <label for="status">{{ __('forms.mission.status.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="is_featured" name="is_featured" required>
                                <option value="1" {{ old('is_featured', (int) $mission->is_featured) == 1 ? 'selected' : '' }}>{{ __('forms.mission.featured.spotlight') }}</option>
                                <option value="0" {{ old('is_featured', (int) $mission->is_featured) == 0 ? 'selected' : '' }}>{{ __('forms.mission.featured.set-back') }}</option>
                            </select>
                            <label for="is_featured">{{ __('forms.mission.featured.title') }}</label>
                        </div>
                    </div>

                    <div class="col-md-12 col-xs-12 mb-3">
                        <label for="description" class="form-label">{{ __('forms.mission.description') }}</label>
                        <textarea class="form-control" id="description" rows="6" name="description" required>{{ old('description', $mission->description) }}</textarea>
                    </div>

                    <div class="col-md-12 col-xs-12 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="searchIcon" placeholder="Rechercher une icône...">
                            <label for="searchIcon">{{ __('forms.mission.icon') }}</label>
                        </div>
                        <div>
                            <strong>{{ __('forms.mission.preview') }}</strong>
                            <i id="preview"></i>
                        </div>
                        <div id="icons"></div>

                        <input type="hidden" id="iconValue" name="icon" value="{{ old('icon', $mission->icon) }}" required>
                    </div>

                    <div class="col-md-12 col-xs-12 my-4">
                        <div class="buttons">
                            <a href="{{ route('missions.index') }}" class="btn secondary">{{ __('buttons.cancel') }}</a>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const icons = @json($icons);
            const selectedIcon = @json(old('icon', $mission->icon));
            const container = document.getElementById("icons");
            const preview = document.getElementById("preview");
            const input = document.getElementById("iconValue");
            const search = document.getElementById("searchIcon");

            function renderIcons(list) {
                container.innerHTML = "";
                list.forEach(icon => {
                    let i = document.createElement("i");
                    i.className = icon + " icon-item";
                    i.dataset.icon = icon;
                    if (icon === input.value) {
                        i.classList.add("icon-selected");
                    }
                    container.appendChild(i);
                });
            }

            input.value = selectedIcon;
            preview.className = selectedIcon || "";
            renderIcons(icons);

            container.addEventListener("click", function(e){
                if (e.target.classList.contains("icon-item")) {
                    document.querySelectorAll(".icon-item").forEach(el => el.classList.remove("icon-selected"));
                    e.target.classList.add("icon-selected");
                    preview.className = e.target.dataset.icon;
                    input.value = e.target.dataset.icon;
                }
            });

            search.addEventListener("keyup", function(){
                let value = this.value.toLowerCase();
                let filtered = icons.filter(i => i.toLowerCase().includes(value));
                renderIcons(filtered);
            });
        });
    </script>
@endsection

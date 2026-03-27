@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/mission/create.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.mission.new') }}"
        :items="[
            ['label' => __('dashboard.sidebar.mission.create')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.mission.create') }}
            </h2>
            <form action="{{ route('missions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-xs-12 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="" id="title" name="title" required>
                            <label for="title">{{ __('forms.mission.title') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 mb-3">
                        <div class="form-group cover">
                            <label for="cover">{{ __('forms.mission.cover') }}</label>
                            <input type="file" class="form-control" id="cover" name="cover" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 my-3 switch-container">
                        <div class="form-check form-switch form-check-reverse">
                            <input class="form-check-input status-checkbox" type="checkbox" id="status">
                            <label class="form-check-label" for="status">
                                {{ __('forms.mission.status.title') }}
                                <span id="isActive"></span>
                                <input type="hidden" name="status" id="is_status" value="0">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 my-3 switch-container">
                        <div class="form-check form-switch form-check-reverse">
                            <input class="form-check-input status-checkbox" type="checkbox" id="featured">
                            <label class="form-check-label" for="featured">
                                {{ __('forms.mission.featured.title') }}
                                <span id="isFeatured"></span>
                                <input type="hidden" name="is_featured" id="is_featured" value="0">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 mb-3">
                        <div class="form-group">
                            <label for="description">{{ __('forms.mission.description') }}</label>
                            <textarea class="form-control" placeholder="" id="description" rows="5" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="" id="searchIcon" placeholder="Rechercher une icône...">
                            <label for="searchIcon">{{ __('forms.mission.icon') }}</label>
                        </div>
                        <div>
                            <strong>{{ __('forms.mission.preview') }}</strong>
                            <i id="preview"></i>
                        </div>
                        <div id="icons"></div>

                        <input type="hidden" id="iconValue" name="icon" value="" required>
                    </div>
                    <div class="col-md-12 col-xs-12 my-5">
                        <div class="buttons">
                            <a href="{{ route('missions.index') }}" class="btn secondary">
                                {{ __('buttons.cancel') }}
                            </a>
                            <button class="btn success" name="action" value="save">
                                {{ __('buttons.save') }}
                            </button>
                            <button class="btn third" name="action" value="continue">
                                {{ __('buttons.save-continue') }}
                            </button>
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

        const statusActive = "{{ __('forms.mission.status.active') }}";
        const statusInactive = "{{ __('forms.mission.status.inactive') }}";
        const statusSpotlight = "{{ __('forms.mission.featured.spotlight') }}";
        const statusSetBack = "{{ __('forms.mission.featured.set-back') }}";

        $(document).ready(function () {

            function updateStatus() {
                if ($('#status').is(':checked')) {
                    $('#is_status').val(1);
                    $('#isActive').text(statusActive);
                    $('#isActive').removeClass('cross');
                    $('#isActive').addClass('check');
                } else {
                    $('#is_status').val(0);
                    $('#isActive').text(statusInactive);
                    $('#isActive').removeClass('check');
                    $('#isActive').addClass('cross');
                }
                if ($('#featured').is(':checked')) {
                    $('#is_featured').val(1);
                    $('#isFeatured').text(statusSpotlight);
                    $('#isFeatured').removeClass('cross');
                    $('#isFeatured').addClass('check');
                } else {
                    $('#is_featured').val(0);
                    $('#isFeatured').text(statusSetBack);
                    $('#isFeatured').removeClass('check');
                    $('#isFeatured').addClass('cross');
                }
            }

            $('.status-checkbox').on('change', function () {
                updateStatus($(this));
            });

            // initialisation
            $('.status-checkbox').each(function () {
                updateStatus($(this));
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const icons = @json($icons);
            console.log(icons);

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
                    container.appendChild(i);
                });
            }

            renderIcons(icons);

            // Délégation : un seul listener sur le container
            container.addEventListener("click", function(e){
                if(e.target.classList.contains("icon-item")) {
                    // retirer la classe sélectionnée des autres icônes
                    document.querySelectorAll(".icon-item").forEach(el => el.classList.remove("icon-selected"));

                    e.target.classList.add("icon-selected");

                    // mettre à jour la preview et input
                    preview.className = e.target.dataset.icon;
                    input.value = e.target.dataset.icon;

                    console.log("Selected icon:", e.target.dataset.icon);
                }
            });

            search.addEventListener("keyup", function(){
                let value = this.value.toLowerCase();
                let filtered = icons.filter(i => i.includes(value));
                renderIcons(filtered);
            });
        });
    </script>

@endsection

@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/mission/create.css') }}">
    <style>
    #iconPicker{
    width:300px;
    border:1px solid #ccc;
    padding:10px;
    border-radius:5px;
    }

    #searchIcon{
    width:100%;
    padding:8px;
    margin-bottom:10px;
    }

    #icons{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:10px;
    max-height:200px;
    overflow:auto;
    }

    .icon-item{
    cursor:pointer;
    font-size:20px;
    padding:8px;
    text-align:center;
    border-radius:4px;
    }

    .icon-item:hover{
    background:#eee;
    }

    #preview{
    font-size:30px;
    margin-top:15px;
    }

    </style>
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
                    <div class="col-md-6 col-xs-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="" id="floatingInput" name="title" required>
                            <label for="floatingInput">{{ __('forms.mission.title') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="floatingInput" name="cover" required>
                            <label for="floatingInput">{{ __('forms.mission.cover') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12"></div>
                    <div class="col-md-6 col-xs-12"></div>
                    <div class="col-md-12 col-xs-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="" id="floatingTextarea" rows="5"></textarea>
                            <label for="floatingTextarea">Comments</label>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12"></div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js_2')
    <script>
        const icons = [
            "fa-solid fa-user",
            "fa-solid fa-house",
            "fa-solid fa-envelope",
            "fa-solid fa-phone",
            "fa-solid fa-star",
            "fa-solid fa-heart",
            "fa-solid fa-camera",
            "fa-solid fa-car",
            "fa-solid fa-bell",
            "fa-solid fa-book",
            "fa-solid fa-gear",
            "fa-solid fa-image",
            "fa-solid fa-location-dot",
            "fa-solid fa-lock",
            "fa-solid fa-music",
            "fa-solid fa-cart-shopping",
            "fa-solid fa-comment",
            "fa-solid fa-calendar",
            "fa-solid fa-cloud",
            "fa-solid fa-download",
            "fa-solid fa-abacus",

        ];

        const container = document.getElementById("icons");
        const preview = document.getElementById("preview");
        const input = document.getElementById("iconValue");
        const search = document.getElementById("searchIcon");

        function renderIcons(list){

            container.innerHTML="";
            list.forEach(icon => {
                let i = document.createElement("i");
                i.className = icon + " icon-item";
                i.dataset.icon = icon;
                i.onclick = function(){
                    preview.className = icon;
                    input.value = icon;
                    console.log("Selected icon:", icon);
                };
                container.appendChild(i);
            });
        }
        renderIcons(icons);
        search.addEventListener("keyup",function(){
            let value = this.value.toLowerCase();
            let filtered = icons.filter(i => i.includes(value));
            renderIcons(filtered);
        });

    </script>

@endsection

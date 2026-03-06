@extends('layouts.admin.app')

@php
    $index = 1;
@endphp

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/user/index.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.user.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.user.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.list') }}
            </h2>
            <a class="btn btn-success" href="{{ route('users.create') }}">
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <div class="d-none d-md-block table-responsive">
                <table class="table table-hover">
                    <thead id="myTableHead" class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('user.index.name') }}</th>
                            <th scope="col">{{ __('user.index.surname') }}</th>
                            <th scope="col">{{ __('user.index.email') }}</th>
                            <th scope="col">{{ __('user.index.phone') }}</th>
                            <th scope="col">{{ __('user.index.gender') }}</th>
                            <th scope="col" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">{{ __('user.index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="desktopTableBody">
                        @forelse ($users as $user)
                            <tr>
                                <td data-label="#">{{ $index++ }}</td>
                                <td data-label="{{ __('user.index.name') }}">{{ $user->name }}</td>
                                <td data-label="{{ __('user.index.surname') }}">{{ $user->surname }}</td>
                                <td data-label="{{ __('user.index.email') }}">{{ $user->email }}</td>
                                <td data-label="{{ __('user.index.phone') }}">{{ $user->phone }}</td>
                                <td data-label="{{ __('user.index.gender') }}">{{ $user->gender_label }}</td>
                                <td data-label="{{ __('user.index.action') }}" class="d-flex gap-1" id="actions">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"  id="deleteForm-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button  type="button" onclick="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">{{ __('user.index.not-found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-md-none" {{-- id="userAccordion"  --}}id="mobileUsers">
                <div class="accordion" id="userAccordion"></div>
                @forelse($users as $user)
                    <div class="card my-3">
                        <div class="card-header d-flex justify-content-between align-items-center" id="heading{{ $user->id }}">
                            <div>
                                <strong>{{ $user->name }} {{ $user->surname }}</strong>
                            </div>
                            <!-- Toggle collapse -->
                            <button class="btn btn-link p-0 ms-2 toggle-chevron" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $user->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $user->id }}">
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        </div>

                        <div id="collapse{{ $user->id }}" class="collapse" aria-labelledby="heading{{ $user->id }}" data-bs-parent="#userAccordion">
                            <div class="card-body">
                                <p><strong>{{ __('user.index.email') }} :</strong> {{ $user->email }}</p>
                                <p><strong>{{ __('user.index.phone') }} :</strong> {{ $user->phone }}</p>
                                <p><strong>{{ __('user.index.gender') }} :</strong> {{ $user->gender }}</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Actions en haut à droite -->
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="deleteForm-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button  type="button" onclick="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('js_2')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sélectionner toutes les flèches
            const toggles = document.querySelectorAll(".toggle-chevron");

            toggles.forEach(btn => {
                const icon = btn.querySelector("i"); // l'icône à faire tourner
                const targetId = btn.getAttribute("data-bs-target");
                const collapseEl = document.querySelector(targetId);

                // Quand le collapse s'ouvre → tourner la flèche
                collapseEl.addEventListener("show.bs.collapse", () => {
                    icon.classList.add("fa-rotate-180");
                });

                // Quand le collapse se ferme → remettre flèche vers le bas
                collapseEl.addEventListener("hide.bs.collapse", () => {
                    icon.classList.remove("fa-rotate-180");
                });
            });
        });

        const darkBtn = document.querySelector('.dark-button');
        const lightBtn = document.querySelector('.light-button');
        const thead = document.getElementById('myTableHead');

        darkBtn.addEventListener('click', () => {
            thead.classList.remove('table-light');
            thead.classList.add('table-dark');

            darkBtn.style.display = 'none';
            lightBtn.style.display = 'inline-block';
        });

        lightBtn.addEventListener('click', () => {
            thead.classList.remove('table-dark');
            thead.classList.add('table-light');

            lightBtn.style.display = 'none';
            darkBtn.style.display = 'inline-block';
        });
    </script>

    <script>
        let timeout = null;

        document.getElementById('searchInput').addEventListener('keyup', function () {

            clearTimeout(timeout);
            let search = this.value;

            timeout = setTimeout(() => {

                fetch(`/users?search=${search}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    let desktopHtml = '';
                    let mobileHtml = '';

                    if (data.data.length === 0) {

                        desktopHtml = `
                            <tr>
                                <td colspan="7" class="text-center">
                                    {{ __('user.index.not-found') }}
                                </td>
                            </tr>
                        `;

                        mobileHtml = `
                            <div class="text-center my-3">
                                {{ __('user.index.not-found') }}
                            </div>
                        `;

                    } else {

                        let index = 1;

                        data.data.forEach(user => {

                            // DESKTOP
                            desktopHtml += `
                                <tr>
                                    <td>${index++}</td>
                                    <td>${user.name}</td>
                                    <td>${user.surname}</td>
                                    <td>${user.email}</td>
                                    <td>${user.phone ?? ''}</td>
                                    <td>${user.gender_label ?? ''}</td>
                                    <td class="d-flex gap-1">
                                        <a href="/users/${user.id}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="/users/${user.id}/edit" class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                            `;

                            // MOBILE
                            mobileHtml += `
                                <div class="card my-3">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <strong>${user.name} ${user.surname}</strong>
                                        <button class="btn btn-link p-0" data-bs-toggle="collapse"
                                            data-bs-target="#collapse${user.id}">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </div>

                                    <div id="collapse${user.id}" class="collapse">
                                        <div class="card-body">
                                            <p><strong>Email :</strong> ${user.email}</p>
                                            <p><strong>Phone :</strong> ${user.phone ?? ''}</p>
                                            <p><strong>Gender :</strong> ${user.gender_label ?? ''}</p>
                                        </div>
                                        <div class="card-footer d-flex gap-2">
                                            <a href="/users/${user.id}" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="/users/${user.id}/edit" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    }

                    document.getElementById('desktopTableBody').innerHTML = desktopHtml;
                    document.getElementById('mobileUsers').innerHTML = mobileHtml;

                });

            }, 400); // debounce
        });
    </script>
@endsection

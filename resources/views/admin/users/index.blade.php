@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/user/index.css') }}">
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
    @php
        $columns = [
            [
                'label' => '#',
                'value' => fn ($user, $loop) => $loop->iteration,
                'show_in_accordion' => false,
            ],
            [
                'label' => __('user.index.name'),
                'field' => 'name',
                'show_in_accordion' => false,
            ],
            [
                'label' => __('user.index.surname'),
                'field' => 'surname',
                'show_in_accordion' => false,
            ],
            [
                'label' => __('user.index.email'),
                'field' => 'email',
            ],
            [
                'label' => __('user.index.phone'),
                'field' => 'phone',
                'value' => fn ($user) => $user->full_phone ?: '-',
            ],
            [
                'label' => __('user.index.gender'),
                'value' => fn ($user) => $user->gender_label ?: '-',
            ],
        ];

        $actions = [
            [
                'icon' => 'fa-solid fa-eye',
                'tooltip' => __('buttons.show'),
                'class' => 'btn btn-sm listing-action listing-action--view',
                'url' => fn ($user) => route('users.show', $user->id),
            ],
            [
                'icon' => 'fa-solid fa-pen',
                'tooltip' => __('buttons.edit'),
                'class' => 'btn btn-sm listing-action listing-action--edit',
                'visible' => fn ($user) => auth()->user()->can('update', $user),
                'url' => fn ($user) => route('users.edit', $user->id),
            ],
            [
                'icon' => 'fa-solid fa-trash',
                'tooltip' => __('buttons.delete'),
                'class' => 'btn btn-sm listing-action listing-action--delete',
                'visible' => fn ($user) => auth()->user()->can('delete', $user),
                'onclick' => fn () => "if(typeof showPopup==='function'){showPopup('confirm', "
                    . \Illuminate\Support\Js::from(__('user.delete.confirm'))
                    . ", {theme:'dark', onConfirm: () => this.closest('form').submit()});}else if(confirm("
                    . \Illuminate\Support\Js::from(__('user.delete.confirm'))
                    . ")){this.closest('form').submit();}",
                'form' => [
                    'action' => fn ($user) => route('users.destroy', $user->id),
                    'method' => 'DELETE',
                ],
            ],
        ];
    @endphp

    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('users.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <x-admin.listing
                :items="$users"
                :columns="$columns"
                :actions="$actions"
                :accordion-title="fn ($user) => $user->name . ' ' . $user->surname"
                :empty-message="__('user.index.not-found')"
                :actions-label="__('user.index.action')"
                table-head-id="myTableHead"
                table-body-id="desktopTableBody"
                mobile-container-id="mobileUsers"
                accordion-parent-id="userAccordion"
                id="users-listing"
            />
        </div>
    </div>
@endsection

@section('js_2')
    <script>
        const darkBtn = document.querySelector('.dark-button');
        const lightBtn = document.querySelector('.light-button');
        const thead = document.getElementById('myTableHead');

        if (darkBtn && lightBtn && thead) {
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
        }
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
                                    <td>${user.full_phone ?? ''}</td>
                                    <td>${user.gender_label ?? ''}</td>
                                    <td>
                                        <div class="listing-inline-actions">
                                        <a href="${user.show_url}" class="btn btn-sm listing-action listing-action--view">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        ${user.can_edit ? `<a href="${user.edit_url}" class="btn btn-sm listing-action listing-action--edit"><i class="fa-solid fa-pen"></i></a>` : ''}
                                        ${user.can_delete ? `<form action="/{{ app()->getLocale() }}/users/${user.id}" method="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-sm listing-action listing-action--delete"><i class="fa-solid fa-trash"></i></button></form>` : ''}
                                        </div>
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
                                            <p><strong>Phone :</strong> ${user.full_phone ?? ''}</p>
                                            <p><strong>Gender :</strong> ${user.gender_label ?? ''}</p>
                                        </div>
                                        <div class="card-footer listing-inline-actions">
                                            <a href="${user.show_url}" class="btn btn-sm listing-action listing-action--view">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            ${user.can_edit ? `<a href="${user.edit_url}" class="btn btn-sm listing-action listing-action--edit"><i class="fa-solid fa-pen"></i></a>` : ''}
                                            ${user.can_delete ? `<form action="/{{ app()->getLocale() }}/users/${user.id}" method="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-sm listing-action listing-action--delete"><i class="fa-solid fa-trash"></i></button></form>` : ''}
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
    <style>
        .listing-inline-actions{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            flex-wrap: wrap;
        }
    </style>
@endsection

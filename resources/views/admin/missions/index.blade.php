@extends('layouts.admin.app')

@php
    $index = 1;
@endphp

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/mission/index.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.mission.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.mission.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.mission.list') }}
            </h2>
            <a class="btn btn-success" href="{{ route('missions.create') }}">
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <div class="d-none d-md-block table-responsive">
                <table class="table table-hover">
                    <thead id="myTableHead" class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('missions.index.title') }}</th>
                            <th scope="col">{{ __('missions.index.description') }}</th>
                            <th scope="col">{{ __('missions.index.status.title') }}</th>
                            <th scope="col">{{ __('missions.index.featured.title') }}</th>
                            <th scope="col">{{ __('missions.index.created-by') }}</th>
                            <th scope="col" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">{{ __('missions.index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="desktopTableBody">
                        @forelse ($missions as $mission)
                            <tr>
                                <td data-label="#">{{ $index++ }}</td>
                                <td data-label="{{ __('missions.index.title') }}">{{ $mission->title }}</td>
                                <td data-label="{{ __('missions.index.description') }}" class="text-wrap action">{!! Str::limit($mission->description, 125, '...') !!}</td>
                                <td data-label="{{ __('missions.index.status.title') }}" class="action">{{ $mission->status ? __('missions.index.status.1') : __('missions.index.status.0') }}</td>
                                <td data-label="{{ __('missions.index.featured.title') }}" class="action">{{ $mission->is_featured ? __('missions.index.featured.1') : __('missions.index.featured.0') }}</td>
                                <td data-label="{{ __('missions.index.created-by') }}" class="action">{{ $mission->creator->name ?? __('Unknown') }}</td>
                                <td data-label="{{ __('missions.index.action') }}" class="d-flex gap-1" id="actions">
                                    <a href="{{ route('missions.show', $mission->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    {{-- Toggle publication status --}}
                                    <form id="statusForm-{{ $mission->id }}" action="{{ route('missions.status', [$mission->id, $mission->status ? 0 : 1]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button"
                                            onclick="confirmToggle('statusForm-{{ $mission->id }}', '{{ __('missions.index.status.confirm') }}')"
                                            class="btn btn-sm {{ $mission->status ? 'btn-unact' : 'btn-action' }}">
                                            <i class="fa-solid {{ $mission->status ? 'fa-download' : 'fa-upload' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Toggle publication featured --}}
                                    <form id="featuredForm-{{ $mission->id }}" action="{{ route('missions.featured', [$mission->id, $mission->is_featured ? 0 : 1]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button"
                                            onclick="confirmToggle('featuredForm-{{ $mission->id }}', '{{ __('missions.index.featured.confirm') }}')"
                                            class="btn btn-sm {{ $mission->is_featured ? 'btn-infos' : 'btn-unact' }}">
                                            <i class="fa-regular {{ $mission->is_featured ? 'fa-thumbs-down' : 'fa-thumbs-up' }}"></i>
                                        </button>
                                    </form>
                                    {{-- Delete publication --}}
                                    <form action="{{ route('missions.destroy', $mission->id) }}" method="POST"  id="deleteForm-{{ $mission->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button  type="button" onclick="confirmDelete({{ $mission->id }}, '{{ __('missions.delete.confirm') }}')" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">{{ __('missions.index.not-found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection

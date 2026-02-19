<div class="page-header-title">
    <h5 class="m-b-10">{{ $title }}</h5>
</div>

<ul class="breadcrumb">
    {{-- Home --}}
    <li class="breadcrumb-item">
        <a href="{{ route('index') }}">
            {{ __('dashboard.header.home') }}
        </a>
    </li>

    {{-- Dashboard --}}
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">
            {{ __('dashboard.sidebar.dashboard') }}
        </a>
    </li>

    {{-- Dynamic Levels --}}
    @foreach($items as $item)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            @if(!$loop->last && isset($item['route']))
                <a href="{{ route($item['route']) }}">
                    {{ $item['label'] }}
                </a>
            @else
                {{ $item['label'] }}
            @endif
        </li>
    @endforeach
</ul>

@props([
    'items' => [],
    'columns' => [],
    'actions' => [],
    'emptyMessage' => 'Aucune donnee disponible.',
    'actionsLabel' => 'Actions',
    'accordionTitle' => null,
    'accordionParentId' => null,
    'tableHeadId' => null,
    'tableBodyId' => null,
    'mobileContainerId' => null,
    'id' => null,
])

@php
    if ($items instanceof \Illuminate\Contracts\Pagination\Paginator) {
        $items = $items->getCollection();
    } else {
        $items = collect($items);
    }
    $componentId = $id ?: 'listing-' . \Illuminate\Support\Str::uuid();
    $accordionParentId = $accordionParentId ?: $componentId . '-accordion';
    $tableHeadId = $tableHeadId ?: $componentId . '-head';
    $tableBodyId = $tableBodyId ?: $componentId . '-body';
    $mobileContainerId = $mobileContainerId ?: $componentId . '-mobile';

    $resolveValue = function ($definition, $item, $loop = null) {
        if ($definition instanceof \Closure) {
            return $definition($item, $loop);
        }

        if (is_string($definition)) {
            return data_get($item, $definition);
        }

        return $definition;
    };
    $resolveActionValue = function ($definition, $item, $loop = null) {
        if ($definition instanceof \Closure) {
            return $definition($item, $loop);
        }

        return $definition;
    };

    $tableColumns = collect($columns)->filter(fn ($column) => $column['show_in_table'] ?? true)->values();
    $accordionColumns = collect($columns)->filter(fn ($column) => $column['show_in_accordion'] ?? true)->values();
@endphp

<div class="reusable-listing">
    <div class="d-none d-md-block table-responsive">
        <table class="table table-hover">
            <thead id="{{ $tableHeadId }}" class="table-light">
                <tr>
                    @foreach ($tableColumns as $column)
                        <th
                            scope="col"
                            class="{{ $column['th_class'] ?? '' }}"
                            @if (!empty($column['th_style'])) style="{{ $column['th_style'] }}" @endif
                        >
                            {{ $column['label'] ?? '' }}
                        </th>
                    @endforeach
                    <th scope="col" class="text-center">{{ $actionsLabel }}</th>
                </tr>
            </thead>
            <tbody id="{{ $tableBodyId }}">
                @forelse ($items as $item)
                    @php
                        $itemLoop = $loop;
                    @endphp
                    <tr>
                        @foreach ($tableColumns as $column)
                            @php
                                $value = $resolveValue($column['value'] ?? ($column['field'] ?? null), $item, $itemLoop);
                                $label = $column['label'] ?? '';
                            @endphp
                            <td
                                data-label="{{ $label }}"
                                class="{{ $column['td_class'] ?? '' }}"
                                @if (!empty($column['td_style'])) style="{{ $column['td_style'] }}" @endif
                            >
                                {!! $value !!}
                            </td>
                        @endforeach
                        <td data-label="{{ $actionsLabel }}" class="reusable-listing__actions">
                            <div class="d-flex flex-wrap justify-content-center align-items-center gap-1">
                                @foreach ($actions as $action)
                                    @php
                                        $isVisible = $resolveActionValue($action['visible'] ?? true, $item, $itemLoop);
                                        $tooltip = $resolveActionValue($action['tooltip'] ?? '', $item, $itemLoop);
                                        $icon = $resolveActionValue($action['icon'] ?? '', $item, $itemLoop);
                                        $classes = trim((string) $resolveActionValue($action['class'] ?? 'btn btn-sm btn-primary', $item, $itemLoop));
                                        $onclick = $resolveActionValue($action['onclick'] ?? null, $item, $itemLoop);
                                        $url = $resolveActionValue($action['url'] ?? ($action['href'] ?? null), $item, $itemLoop);
                                        $type = $resolveActionValue($action['type'] ?? 'button', $item, $itemLoop);
                                        $attributes = $action['attributes'] ?? [];
                                        $attributesString = '';
                                        foreach ($attributes as $attribute => $attributeValue) {
                                            $attributesString .= $attribute . '="' . e($resolveActionValue($attributeValue, $item, $itemLoop)) . '" ';
                                        }
                                        $form = $action['form'] ?? null;
                                    @endphp

                                    @continue(!$isVisible)

                                    @if ($form)
                                        @php
                                            $formId = $resolveActionValue($form['id'] ?? null, $item, $itemLoop);
                                            $formAction = $resolveActionValue($form['action'] ?? null, $item, $itemLoop);
                                            $formMethod = strtoupper($form['method'] ?? 'POST');
                                        @endphp
                                        <form action="{{ $formAction }}" method="POST" @if($formId) id="{{ $formId }}" @endif>
                                            @csrf
                                            @if (!in_array($formMethod, ['GET', 'POST'], true))
                                                @method($formMethod)
                                            @endif
                                            <button
                                                type="{{ $type }}"
                                                class="{{ $classes }}"
                                                title="{{ $tooltip }}"
                                                aria-label="{{ $tooltip }}"
                                                @if ($onclick) onclick="{{ $onclick }}" @endif
                                                @foreach ($attributes as $attribute => $attributeValue)
                                                    {{ $attribute }}="{{ $resolveActionValue($attributeValue, $item, $itemLoop) }}"
                                                @endforeach
                                            >
                                                <i class="{{ $icon }}"></i>
                                            </button>
                                        </form>
                                    @elseif ($url)
                                        <a
                                            href="{{ $url }}"
                                            class="{{ $classes }}"
                                            title="{{ $tooltip }}"
                                            aria-label="{{ $tooltip }}"
                                            @if ($onclick) onclick="{{ $onclick }}" @endif
                                            @foreach ($attributes as $attribute => $attributeValue)
                                                {{ $attribute }}="{{ $resolveActionValue($attributeValue, $item, $itemLoop) }}"
                                            @endforeach
                                        >
                                            <i class="{{ $icon }}"></i>
                                        </a>
                                    @else
                                        <button
                                            type="{{ $type }}"
                                            class="{{ $classes }}"
                                            title="{{ $tooltip }}"
                                            aria-label="{{ $tooltip }}"
                                            @if ($onclick) onclick="{{ $onclick }}" @endif
                                            @foreach ($attributes as $attribute => $attributeValue)
                                                {{ $attribute }}="{{ $resolveActionValue($attributeValue, $item, $itemLoop) }}"
                                            @endforeach
                                        >
                                            <i class="{{ $icon }}"></i>
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $tableColumns->count() + 1 }}" class="text-center">{{ $emptyMessage }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-md-none" id="{{ $mobileContainerId }}">
        <div class="accordion" id="{{ $accordionParentId }}">
            @forelse ($items as $item)
                @php
                    $itemLoop = $loop;
                    $itemKey = data_get($item, 'id', $itemLoop->iteration);
                    $collapseId = $componentId . '-collapse-' . $itemKey;
                    $headingId = $componentId . '-heading-' . $itemKey;
                    $title = $resolveValue($accordionTitle, $item, $itemLoop);
                @endphp
                <div class="card my-3">
                    <div class="card-header d-flex justify-content-between align-items-center" id="{{ $headingId }}">
                        <div>
                            <strong>{{ $title }}</strong>
                        </div>
                        <button
                            class="btn btn-link p-0 ms-2 toggle-chevron reusable-listing__toggle"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $collapseId }}"
                            aria-expanded="false"
                            aria-controls="{{ $collapseId }}"
                        >
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                    </div>

                    <div
                        id="{{ $collapseId }}"
                        class="collapse"
                        aria-labelledby="{{ $headingId }}"
                        data-bs-parent="#{{ $accordionParentId }}"
                    >
                        <div class="card-body">
                            @foreach ($accordionColumns as $column)
                                @php
                                    $value = $resolveValue($column['value'] ?? ($column['field'] ?? null), $item, $itemLoop);
                                @endphp
                                <p class="mb-2">
                                    <strong>{{ $column['label'] ?? '' }} :</strong> {!! $value !!}
                                </p>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @foreach ($actions as $action)
                                    @php
                                        $isVisible = $resolveActionValue($action['visible'] ?? true, $item, $itemLoop);
                                        $tooltip = $resolveActionValue($action['tooltip'] ?? '', $item, $itemLoop);
                                        $icon = $resolveActionValue($action['icon'] ?? '', $item, $itemLoop);
                                        $classes = trim((string) $resolveActionValue($action['class'] ?? 'btn btn-sm btn-primary', $item, $itemLoop));
                                        $onclick = $resolveActionValue($action['onclick'] ?? null, $item, $itemLoop);
                                        $url = $resolveActionValue($action['url'] ?? ($action['href'] ?? null), $item, $itemLoop);
                                        $type = $resolveActionValue($action['type'] ?? 'button', $item, $itemLoop);
                                        $attributes = $action['attributes'] ?? [];
                                        $form = $action['form'] ?? null;
                                    @endphp

                                    @continue(!$isVisible)

                                    @if ($form)
                                        @php
                                            $formId = $resolveActionValue($form['id'] ?? null, $item, $itemLoop);
                                            $formAction = $resolveActionValue($form['action'] ?? null, $item, $itemLoop);
                                            $formMethod = strtoupper($form['method'] ?? 'POST');
                                        @endphp
                                        <form action="{{ $formAction }}" method="POST" @if($formId) id="{{ $formId }}" @endif>
                                            @csrf
                                            @if (!in_array($formMethod, ['GET', 'POST'], true))
                                                @method($formMethod)
                                            @endif
                                            <button
                                                type="{{ $type }}"
                                                class="{{ $classes }}"
                                                title="{{ $tooltip }}"
                                                aria-label="{{ $tooltip }}"
                                                @if ($onclick) onclick="{{ $onclick }}" @endif
                                                @foreach ($attributes as $attribute => $attributeValue)
                                                    {{ $attribute }}="{{ $resolveActionValue($attributeValue, $item, $itemLoop) }}"
                                                @endforeach
                                            >
                                                <i class="{{ $icon }}"></i>
                                            </button>
                                        </form>
                                    @elseif ($url)
                                        <a
                                            href="{{ $url }}"
                                            class="{{ $classes }}"
                                            title="{{ $tooltip }}"
                                            aria-label="{{ $tooltip }}"
                                            @if ($onclick) onclick="{{ $onclick }}" @endif
                                            @foreach ($attributes as $attribute => $attributeValue)
                                                {{ $attribute }}="{{ $resolveActionValue($attributeValue, $item, $itemLoop) }}"
                                            @endforeach
                                        >
                                            <i class="{{ $icon }}"></i>
                                        </a>
                                    @else
                                        <button
                                            type="{{ $type }}"
                                            class="{{ $classes }}"
                                            title="{{ $tooltip }}"
                                            aria-label="{{ $tooltip }}"
                                            @if ($onclick) onclick="{{ $onclick }}" @endif
                                            @foreach ($attributes as $attribute => $attributeValue)
                                                {{ $attribute }}="{{ $resolveActionValue($attributeValue, $item, $itemLoop) }}"
                                            @endforeach
                                        >
                                            <i class="{{ $icon }}"></i>
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center my-3">{{ $emptyMessage }}</div>
            @endforelse
        </div>
    </div>
</div>

@once
    <style>
        .reusable-listing__actions .btn,
        .reusable-listing .card-footer .btn {
            font-size: .95rem !important;
        }

        .reusable-listing__actions .d-flex,
        .reusable-listing .card-footer .d-flex {
            gap: .45rem !important;
        }

        .listing-action {
            min-width: 42px;
            height: 42px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            border-radius: 14px !important;
            border: 1px solid transparent !important;
            background: #f5f7fb !important;
            box-shadow: 0 8px 18px rgba(11, 60, 93, 0.08);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease, background-color .18s ease;
        }

        .listing-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 22px rgba(11, 60, 93, 0.12);
        }

        .listing-action--view,
        .reusable-listing__actions .btn-primary,
        .reusable-listing .card-footer .btn-primary {
            color: #0b3c5d !important;
            background: rgba(11, 60, 93, 0.08) !important;
            border-color: rgba(11, 60, 93, 0.12) !important;
        }

        .listing-action--edit,
        .reusable-listing__actions .btn-warning,
        .reusable-listing .card-footer .btn-warning {
            color: #f57c00 !important;
            background: rgba(245, 124, 0, 0.10) !important;
            border-color: rgba(245, 124, 0, 0.18) !important;
        }

        .listing-action--delete,
        .reusable-listing__actions .btn-danger,
        .reusable-listing .card-footer .btn-danger {
            color: #d9534f !important;
            background: rgba(217, 83, 79, 0.10) !important;
            border-color: rgba(217, 83, 79, 0.18) !important;
        }

        .listing-action--accent {
            color: #135f92 !important;
            background: rgba(19, 95, 146, 0.10) !important;
            border-color: rgba(19, 95, 146, 0.18) !important;
        }

        .listing-action--info {
            color: #2a8f6a !important;
            background: rgba(42, 143, 106, 0.10) !important;
            border-color: rgba(42, 143, 106, 0.18) !important;
        }

        .listing-action--muted {
            color: #6c757d !important;
            background: rgba(108, 117, 125, 0.10) !important;
            border-color: rgba(108, 117, 125, 0.18) !important;
        }

        .reusable-listing__actions form,
        .reusable-listing .card-footer form {
            margin: 0;
        }

        .reusable-listing__toggle {
            text-decoration: none !important;
        }

        .reusable-listing__toggle i {
            transition: transform 0.2s ease;
        }

        .reusable-listing__toggle i.fa-rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.reusable-listing .collapse').forEach(function (collapseEl) {
                const trigger = document.querySelector('[data-bs-target="#' + collapseEl.id + '"]');
                const icon = trigger ? trigger.querySelector('i') : null;

                if (!icon || collapseEl.dataset.listingBound === 'true') {
                    return;
                }

                collapseEl.dataset.listingBound = 'true';

                collapseEl.addEventListener('show.bs.collapse', function () {
                    icon.classList.add('fa-rotate-180');
                });

                collapseEl.addEventListener('hide.bs.collapse', function () {
                    icon.classList.remove('fa-rotate-180');
                });
            });
        });
    </script>
@endonce

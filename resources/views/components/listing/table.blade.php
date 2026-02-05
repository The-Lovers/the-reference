<div class="bg-white p-4 rounded shadow">

    {{-- Search + Filters --}}
    <form method="GET" action="{{ route($route) }}" class="flex gap-2 mb-4">

        {{-- Search --}}
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="{{ $searchPlaceholder }}"
            class="border rounded px-3 py-2 w-64"
        >

        {{-- Dynamic filters --}}
        @foreach($filters as $filter)
            <select name="{{ $filter['name'] }}" class="border rounded px-3 py-2">
                <option value="">Tous</option>

                @foreach($filter['options'] as $key => $label)
                    <option
                        value="{{ $key }}"
                        @selected(request($filter['name']) == $key)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        @endforeach

        <button class="bg-blue-600 text-white px-4 rounded">
            Filtrer
        </button>
    </form>

    {{-- Table --}}
    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                @foreach($columns as $column)
                    <th class="p-2 text-left">
                        {{ $column['label'] }}
                    </th>
                @endforeach
                <th class="p-2">Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($rows as $row)
            <tr class="border-t">

                {{-- Cells --}}
                @foreach($columns as $column)
                    <td class="p-2">
                        {{ data_get($row, $column['field']) }}
                    </td>
                @endforeach

                {{-- Actions --}}
                <td class="p-2 flex gap-2">

                    {{-- Show --}}
                    <a href="{{ route($route.'.show', $row->id) }}"
                       class="text-blue-600">
                        Voir
                    </a>

                    {{-- Edit --}}
                    <a href="{{ route($route.'.edit', $row->id) }}"
                       class="text-yellow-600">
                        Edit
                    </a>

                    {{-- Delete --}}
                    <form method="POST"
                          action="{{ route($route.'.destroy', $row->id) }}">
                        @csrf
                        @method('DELETE')
                        <button
                            onclick="return confirm('Supprimer ?')"
                            class="text-red-600">
                            Delete
                        </button>
                    </form>

                    {{-- Toggle active --}}
                    @if(isset($row->active))
                        <a href="{{ route($route.'.toggle', $row->id) }}"
                           class="text-green-600">
                            {{ $row->active ? 'Désactiver' : 'Activer' }}
                        </a>
                    @endif

                    {{-- Toggle published --}}
                    @if(isset($row->published))
                        <a href="{{ route($route.'.publish', $row->id) }}"
                           class="text-purple-600">
                            {{ $row->published ? 'Unpublish' : 'Publish' }}
                        </a>
                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" class="p-4 text-center text-gray-500">
                    Aucun résultat
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $rows->withQueryString()->links() }}
    </div>
</div>

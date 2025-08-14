@props([
    'items',
    'columns',
])

<div class="overflow-x-auto overflow-hidden rounded-lg border border-gray-300">
    <table class="min-w-full table-fixed text-sm border-collapse">
        <thead class="bg-gray-100">
            <tr>
                @foreach ($columns as $column)
                    <th class="px-4 py-2 text-left font-semibold text-gray-700 border-b border-r border-gray-300 {{ $column['headerClass'] ?? '' }}">
                        {{ $column['label'] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr class="hover:bg-gray-50">
                    @foreach ($columns as $column)
                        <td class="px-4 py-2 border-b border-r border-gray-200 {{ $column['cellClass'] ?? '' }}">
                            @if(isset($column['callback']) && is_callable($column['callback']))
                                {!! $column['callback']($item) !!}
                            @else
                                {{ $item->{$column['field']} ?? '--' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="px-4 py-2 text-center text-gray-500">
                        No data available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

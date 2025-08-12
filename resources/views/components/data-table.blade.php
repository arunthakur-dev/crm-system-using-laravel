<div class="mx-10 mb-10 bg-white border border-gray-200 rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
        <h1 class="text-2xl font-semibold">{{ Str::plural($entity) }}</h1>
        <a href=""
           class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition">
            Create {{ $entity }}
        </a>
    </div>

    <!-- Search and Pagination Info -->
    <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        
        <!-- Left Side -->
        <div class="flex items-center gap-4">
            <p class="text-gray-600 text-sm">
                Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
            </p>

            <form method="GET">
                <label class="text-sm text-gray-600 mr-2">Per page:</label>
                <select name="per_page"
                    class="border border-gray-300 rounded-md px-2 py-1 text-sm"
                    onchange="this.form.submit()">
                    @foreach([5, 10, 20, 30, 40, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Right Side -->
        <div class="flex w-full md:w-auto md:justify-end">
            <form method="GET" class="flex w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name, email, domain ..."
                    class=" w-70 flex-grow border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                <button type="submit"
                    class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-300/50">
            <thead class="bg-gray-50 border-b border-gray-300/50 text-gray-600 uppercase text-xs">
                <tr>
                    @foreach ($columns as $col)
                        <th class="px-4 py-3 border border-gray-300/50">
                            <x-sort-link
                                :field="$col['field']"
                                :label="$col['label']"
                                :sort-field="$sortField"
                                :sort-direction="$sortDirection"
                            />
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @forelse ($items as $item)
                <tr class="hover:bg-gray-50">
                    @foreach ($columns as $col)
                        <td class="px-4 py-3 border border-gray-300/50">
                            @if ($loop->first)
                                <a href="{{ route(strtolower(Str::plural($entity)) . '.show', $item->id) }}"
                                class="text-blue-600 hover:underline">
                                    {{ data_get($item, $col['field']) ?? '--' }}
                                </a>
                            @else
                                {{ data_get($item, $col['field']) ?? '--' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="px-4 py-3 border border-gray-300/50 text-center text-gray-600">
                        No {{ strtolower(Str::plural($entity)) }} found.
                    </td>
                </tr>
            @endforelse
        </tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $items->links() }}
    </div>
</div>

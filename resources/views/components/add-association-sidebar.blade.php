@props([
    'id',
    'entity',
    'createRoute',
    'linkRoute',
    'existingItems',
    'fields' => [],
    'parentId' => null,
    'parentType' => null,
])

<div id="{{ $id }}"
    class="fixed top-0 right-0 w-130 h-full bg-white shadow-lg transform
        transition-transform duration-300 ease-in-out z-50 flex flex-col
        {{ $errors->any() ? 'translate-x-0' : 'translate-x-full' }}">

    <!-- Header -->
    <div class="flex items-center justify-between bg-cyan-600 text-white p-4 flex-shrink-0">
        <h2 class="font-semibold text-lg"> Add New  {{ $entity }}</h2>
        <button class="text-white font-bold text-xl" onclick="closeSidebar('{{ $id }}')">&times;</button>
    </div>

    <div class="flex-1 overflow-y-auto p-4">
        <div class="flex border border-black/20 h-15 mt-5 rounded-md overflow-hidden">
            <button
                class="flex-1 p-2 text-center font-semibold border-r border-black/20 bg-white hover:bg-gray-100 cursor-pointer transition-colors duration-200 active-tab"
                data-tab="create-{{ $id }}">
                Create new
            </button>

            <button
                class="flex-1 p-2 text-center font-semibold bg-white hover:bg-gray-100 cursor-pointer transition-colors duration-200"
                data-tab="existing-{{ $id }}">
                Add existing
            </button>
        </div>

        <style>
            .active-tab {
                @apply bg-orange-50 border-b-2 border-orange-500;
            }
        </style>

        {{-- Create new form --}}
        <div id="create-{{ $id }}" class="tab-content mt-5">
            <x-forms.form method="POST" action="{{ $createRoute }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="link_to_id" value="{{ $parentId ?? '' }}">
                <input type="hidden" name="link_to_type" value="{{ $parentType ?? '' }}">

                @if(empty($fields))
                    <h1> Fields are not available </h1>
                @else
                    @foreach ($fields as $field)
                        @if ($field['type'] === 'textarea')
                            <x-forms.field :label="$field['label']" :name="$field['name']">
                                <textarea
                                    id="{{ $field['name'] }}"
                                    name="{{ $field['name'] }}"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    class="rounded-md bg-black/5 border border-black/10 px-5 py-3 w-full"
                                >{{ old($field['name']) }}</textarea>
                            </x-forms.field>

                        @elseif ($field['type'] === 'select')
                                <x-forms.select
                                    name="{{ $field['name'] }}"
                                    id="{{ $field['name'] }}"
                                    label="{{ $field['label'] }}"
                                    placeholder="{{ $field['placeholder'] ?? '' }}"
                                    class="rounded-md bg-black/5 border border-black/10 px-5 py-3 w-full"
                                >
                                    @foreach ($field['options'] as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" {{ old($field['name']) == $optionValue ? 'selected' : '' }}>
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                </x-forms.select>

                        @else
                            <x-forms.input
                                id="{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                type="{{ $field['type'] }}"
                                label="{{ $field['label'] }}"
                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                class="w-full"
                                :value="old($field['name'])"
                            />
                        @endif
                        <x-forms.error :field="$field['name']" />
                    @endforeach
                @endif
                <x-forms.button type="submit">
                    Add
                </x-forms.button>
            </x-forms.form>
        </div>

        {{-- Add existing --}}
        <div id="existing-{{ $id }}" class="tab-content hidden">
            <form method="POST" action="{{ $linkRoute }}">
                @csrf
                <div class="space-y-2 pb-3">
                    @foreach($existingItems as $item)
                        <div class="border border-black/20 p-4 my-3 rounded-2xl">
                            <x-forms.checkbox
                                :label="(
                                    data_get($item, 'name')
                                    ?? trim((data_get($item, 'first_name') ?? '') . ' ' . (data_get($item, 'last_name') ?? '')) ?: null
                                    ?? data_get($item, 'title')
                                    ?? 'Untitled'
                                )"

                                :label_1="(
                                    data_get($item, 'name')
                                    ?? trim((data_get($item, 'first_name') ?? '') . ' ' . (data_get($item, 'last_name') ?? '')) ?: null
                                    ?? data_get($item, 'title')
                                    ?? 'Untitled'
                                ) . ' - ' . (
                                    data_get($item, 'domain')
                                    ?? data_get($item, 'email')
                                    ?? data_get($item, 'amount')
                                    ?? 'Untitled'
                                )"

                                name="ids[]"
                                value="{{ $item->id }}"
                            />
                        </div>
                    @endforeach
                </div>
                <x-forms.button type="submit">
                    Add
                </x-forms.button>
            </form>
        </div>
    </div>
</div>

<script>
    function openSidebar(id) {
        document.getElementById(id).classList.remove('translate-x-full');
    }
    function closeSidebar(id) {
        document.getElementById(id).classList.add('translate-x-full');
    }

    document.querySelectorAll(`[data-tab]`).forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');
            const container = tab.closest('div').parentNode;
            container.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            container.querySelector(`#${target}`).classList.remove('hidden');
        });
    });
</script>

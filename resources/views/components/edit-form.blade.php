    @props([
    'entity',
    'route',
    'method' => 'PUT',
    'model',
    'fields' => [],
    'allContacts' => [],
    'allCompanies' => [],
])

<div id="editSidebar"
     class="fixed top-0 right-0 w-130 h-full bg-white shadow-lg transform
            transition-transform duration-300 ease-in-out z-50 flex flex-col
            {{ $errors->any() ? 'translate-x-0' : 'translate-x-full' }}">

    <!-- Header -->
    <div class="flex items-center justify-between bg-cyan-600 text-white p-4 flex-shrink-0">
        <h2 class="font-semibold text-lg">Edit {{ $entity }}</h2>
        <button id="closeEditSidebar" class="text-white font-bold text-xl">&times;</button>
    </div>

    <!-- Scrollable body -->
    <div class="flex-1 overflow-y-auto p-4">
        <x-forms.form method="POST" action="{{ $route }}" enctype="multipart/form-data">
            @csrf
            @if(strtoupper($method) !== 'POST')
                @method($method)
            @endif

            @if(empty($fields))
                <h1>Fields are not available</h1>
            @else
                @foreach ($fields as $field)
                    @if ($field['type'] === 'textarea')
                        <x-forms.field :label="$field['label']" :name="$field['name']">
                            <textarea
                                id="{{ $field['name'] }}"
                                name="{{ $field['name'] }}"
                                placeholder="{{ $field['placeholder'] ?? '' }}"
                                class="rounded-md bg-black/5 border border-black/10 px-5 py-3 w-full"
                            >{{ old($field['name'], $model->{$field['name']}) }}</textarea>
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
                                <option value="{{ $optionValue }}"
                                    {{ old($field['name'], $model->{$field['name']}) == $optionValue ? 'selected' : '' }}>
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
                            :value="old($field['name'], $model->{$field['name']})"
                        />
                    @endif
                    <x-forms.error :field="$field['name']" />
                @endforeach
            @endif

            <x-forms.button type="submit">
                Update
            </x-forms.button>
        </x-forms.form>
    </div>
</div>




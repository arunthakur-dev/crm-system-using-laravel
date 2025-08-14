@props([
    'entity',
    'route',
    'fields' => [],
    'allContacts' => [],
    'allCompanies' => [],
])

<div id="sidebar"
     class="fixed top-0 right-0 w-130 h-full bg-white shadow-lg transform
            transition-transform duration-300 ease-in-out z-50 flex flex-col
            {{ $errors->any() ? 'translate-x-0' : 'translate-x-full' }}">

    <!-- Header -->
    <div class="flex items-center justify-between bg-cyan-600 text-white p-4 flex-shrink-0">
        <h2 class="font-semibold text-lg">Create New {{ $entity }}</h2>
        <button id="closeSidebar" class="text-white font-bold text-xl">&times;</button>
    </div>

    <!-- Scrollable body -->
    <div class="flex-1 overflow-y-auto p-4">
        <x-forms.form method="POST" action="{{ $route }}" enctype="multipart/form-data">
            @csrf

        @if(empty($fields))
            {{-- Fallback: single input field component --}}
            <!-- You can add fallback here -->
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
            {{-- Association section for Deals --}}
            @if ($entity === 'Deal')
                <div class="flex items-center justify-between bg-cyan-600 text-white p-4 flex-shrink-0 mt-15">
                    <h2 class="font-semibold text-lg">Associated Deal With</h2>
                </div>
                <div class="mt-6">
                    <div class="mb-4">
                        <x-forms.select label="Contact" name="associated_contact" id="associated_contact" class="rounded-md bg-black/5 border border-black/10 px-5 py-3 w-full">
                            <option value="">--Select Contact--</option>
                            @if (count($allContacts))
                                @foreach ($allContacts as $contact)
                                    <option value="{{ $contact->contact_id }}">{{ $contact->first_name }} {{ $contact->last_name }} - {{ $contact->email }}</option>
                                @endforeach
                            @else
                                <option value="">No contacts available</option>
                            @endif
                        </x-forms.select>
                    </div>
                    <div>
                        <x-forms.select label="Company" name="associated_company" id="associated_company" class="rounded-md bg-black/5 border border-black/10 px-5 py-3 w-full">
                            <option value="">--Select a Company--</option>
                            @if (count($allContacts))
                                @foreach ($allCompanies as $company)
                                    <option value="{{ $company->company_id }}">{{ $company->name }} {{ $company->domain }} - {{ $contact->email }}</option>
                                @endforeach
                            @else
                                <option value="">No contacts available</option>
                            @endif
                        </x-forms.select>
                    </div>
                </div>
            @endif
        @endif
        <x-forms.button type="submit">
            Create
        </x-forms.button>
        </x-forms.form>
    </div>
</div>

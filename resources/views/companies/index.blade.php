<x-layout>
    <x-data-table
        :items="$companies"
        :columns="[
                ['field' => 'name', 'label' => 'Company Name'],
                ['field' => 'domain', 'label' => 'Domain'],
                ['field' => 'owner', 'label' => 'Company Owner'],
                ['field' => 'phone', 'label' => 'Phone Number'],
                ['field' => 'industry', 'label' => 'Industry'],
                ['field' => 'country', 'label' => 'Country/Region'],
                ['field' => 'state', 'label' => 'State/City'],
                ['field' => 'postal_code', 'label' => 'Postal Code'],
                ['field' => 'notes', 'label' => 'Notes'],
                ['field' => 'created_at', 'label' => 'Create Date'],
                ['field' => 'updated_at', 'label' => 'Update Date'],
            ]"
        entity="Company"
        :sortField="$sortField"
        :sortDirection="$sortDirection"
    />

    <x-sidebar-form
        entity="Company"
        route="{{ route('companies.store') }}"
        :fields="[
            ['name' => 'name', 'label' => 'Company Name', 'type' => 'text', 'placeholder' => 'Enter company name'],
            ['name' => 'domain', 'label' => 'Domain', 'type' => 'text', 'placeholder' => 'Enter domain'],
            [
                'name' => 'owner',
                'label' => 'Company Owner',
                'type' => 'select',
                'options' => [
                    'null' => 'No owner',
                    auth()->user()->name => auth()->user()->name . ' (' . auth()->user()->email . ')',
                ]
            ],
            ['name' => 'phone', 'label' => 'Phone Number', 'type' => 'text', 'placeholder' => 'Enter phone number'],
            [
                'name' => 'industry',
                'label' => 'Industry',
                'type' => 'select',
                'options' => [
                    '' => '-- Select industry --',
                    'tech' => 'Technology',
                    'finance' => 'Finance',
                    'healthcare' => 'Healthcare',
                    'education' => 'Education',
                ]
            ],
            ['name' => 'country', 'label' => 'Country/Region', 'type' => 'text', 'placeholder' => 'Enter country/region'],
            ['name' => 'state', 'label' => 'State/City', 'type' => 'text', 'placeholder' => 'Enter state/city'],
            ['name' => 'postal_code', 'label' => 'Postal Code', 'type' => 'text', 'placeholder' => 'Enter postal code'],
            ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea', 'placeholder' => 'Add notes...'],
        ]"
    />
</x-layout>

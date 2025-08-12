<x-layout>
        <!-- Table -->
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
                ['field' => 'created_at', 'label' => 'Create Date'],
                ['field' => 'updated_at', 'label' => 'Update Date'],
            ]"
            entity="Company"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
        />
        </div>
    </div>
</x-layout>

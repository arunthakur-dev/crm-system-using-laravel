<x-layout>
    <!-- Table -->
    <x-data-table
        :items="$contacts"
        :columns="[
            ['field' => 'full_name', 'label' => 'Name'],
            ['field' => 'email', 'label' => 'Email'],
            ['field' => 'owner', 'label' => 'Contact Owner'],
            ['field' => 'phone', 'label' => 'Phone'],
            ['field' => 'lead_status', 'label' => 'Lead Status'],
            ['field' => 'created_at', 'label' => 'Create Date'],
            ['field' => 'updated_at', 'label' => 'Update Date'],
        ]"
        entity="Contact"
        :sortField="$sortField"
        :sortDirection="$sortDirection"
    />

    <x-sidebar-form
        entity="Contact"
        route="{{ route('contacts.store') }}"
        :fields="[
            ['name' => 'first_name', 'label' => 'First Name', 'type' => 'text', 'placeholder' => 'Enter first name'],
            ['name' => 'last_name', 'label' => 'last Name', 'type' => 'text', 'placeholder' => 'Enter last name'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'placeholder' => 'Enter email'],
            [
                'name' => 'owner',
                'label' => 'Contact Owner',
                'type' => 'select',
                'options' => [
                    'null' => 'No owner',
                    auth()->user()->name => auth()->user()->name . ' (' . auth()->user()->email . ')',
                ]
            ],
            ['name' => 'phone', 'label' => 'Phone Number', 'type' => 'text', 'placeholder' => 'Enter phone number'],
            [
                'name' => 'lead_status',
                'label' => 'Lead Status',
                'type' => 'select',
                'options' => [
                    '' => '-- Select lead status --',
                    'new' => 'New',
                    'open' => 'Open',
                    'in progress' => 'In Progress',
                    'open deal' => 'Open Deal',
                    'connected' => 'Connected',
                ]
            ],
        ]"
    />
</x-layout>

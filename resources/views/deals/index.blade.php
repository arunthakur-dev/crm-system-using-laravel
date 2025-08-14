<x-layout>
    <!-- Table -->
    <x-data-table
        :items="$deals"
        :columns="[
            ['field' => 'title', 'label' => 'Title'],
            ['field' => 'amount', 'label' => 'Amount'],
            ['field' => 'owner', 'label' => 'Owner'],
            ['field' => 'status', 'label' => 'Status'],
            ['field' => 'priority', 'label' => 'Priority'],
            ['field' => 'close_date', 'label' => 'Close Date'],
            ['field' => 'created_at', 'label' => 'Create Date'],
            ['field' => 'updated_at', 'label' => 'Update Date'],
        ]"
        entity="Deal"
        :sortField="$sortField"
        :sortDirection="$sortDirection"
    />

    <x-sidebar-form
        entity="Deal"
        route="{{ route('deals.store') }}"
        :allContacts="$allContacts"
        :allCompanies="$allCompanies"

        :fields="[
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'placeholder' => 'Enter deal title'],
            ['name' => 'amount', 'label' => 'Amount', 'type' => 'number', 'placeholder' => 'Enter deal amount'],
            [
                'name' => 'owner',
                'label' => 'Deal Owner',
                'type' => 'select',
                'options' => [
                    'null' => 'No owner',
                    auth()->user()->name => auth()->user()->name . ' (' . auth()->user()->email . ')',
                ]
            ],
            [
                'name' => 'status',
                'label' => 'Deal Stage',
                'type' => 'select',
                'options' => [
                    '' => '-- Select deal stage --',
                    'visitor engaged' => 'Visitor Engaged',
                    'lead captured' => 'Lead Captured',
                    'demo delivered' => 'Demo Delivered',
                    'in engotiation' => 'In Negotiation',
                    'deal won' => 'Deal Won',
                    'deal lost' => 'Deal Lost',
                ]
            ],
            [
                'name' => 'priority',
                'label' => 'Priority',
                'type' => 'select',
                'options' => [
                    '' => '-- Select deal priority --',
                    'high' => 'High',
                    'medium' => 'Medium',
                    'low' => 'Low',
                ]
            ],
            ['name' => 'close_date', 'label' => 'Close Date', 'type' => 'date'],
        ]"
    />
</x-layout>

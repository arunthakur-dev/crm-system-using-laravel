<x-layout>
        <!-- Table -->
        <x-data-table
            :items="$contacts"
            :columns="[
                ['field' => 'first_name', 'label' => 'First Name'],
                ['field' => 'last_name', 'label' => 'Last Name'],
                ['field' => 'email', 'label' => 'Email'],
                ['field' => 'phone', 'label' => 'Phone'],
                ['field' => 'owner', 'label' => 'Contact Owner'],
                ['field' => 'lead_status', 'label' => 'Lead Status'],
                ['field' => 'created_at', 'label' => 'Create Date'],
                ['field' => 'updated_at', 'label' => 'Update Date'],
            ]"
            entity="Contact"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
        />
        </div>
    </div>
</x-layout>

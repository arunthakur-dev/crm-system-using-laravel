<x-layout>
        <!-- Table -->
        <x-data-table
            :items="$deals"
            :columns="[
                ['field' => 'title', 'label' => 'Title'],
                ['field' => 'amount', 'label' => 'Amount'],
                ['field' => 'status', 'label' => 'Status'],
                ['field' => 'priority', 'label' => 'Priority'],
                ['field' => 'close_date', 'label' => 'Close Date'],
                ['field' => 'owner', 'label' => 'Owner'],
                ['field' => 'created_at', 'label' => 'Create Date'],
                ['field' => 'updated_at', 'label' => 'Update Date'],
            ]"
            entity="Deal"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
        />
        </div>
    </div>
</x-layout>

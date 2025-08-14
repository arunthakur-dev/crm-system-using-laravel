<x-layout>
    <div class="flex w-full h-screen ">
        <!-- Sidebar -->
        <x-show-sidebar-card
            :entity="$deal"
            type="Deal"
            :fields="[
                'Owner' => $deal->owner,
                'Amount' => $deal->amount,
                'Status' => $deal->status,
                'Priority' => $deal->priority,
                'Created At' => $deal->created_at,
                'Close Date' => $deal->close_date,
            ]"
            :delete-route="route('deals.destroy', $deal->id)"
        >
            <x-action-buttons />
        </x-sidebar-card>

        <!-- Main Content -->
        <main class="ml-80 overflow-y-auto flex-1 p-6 bg-white border border-black/20 rounded-xl mr-2">

            <!-- Tab and Company Info Grid -->
            <x-tab-info :items="[
                'Create Date' => $deal->created_at->format('d M Y h:i A'),
                'Lifecycle Stage' => 'Lead',
                'Last Activity Date' => '--'
            ]" />

            <!-- Associated Contacts -->
            <div class="mb-8 border p-4 rounded-xl border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Contacts</h3>
                    <button class="text-blue-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($dealContacts->isEmpty())
                    <p class="text-gray-500">No associated contacts yet.</p>
                @else
                    <x-association-table
                        :items="$dealContacts"
                        :columns="[
                            [
                                'label' => 'Title',
                                'callback' => fn($item) => avatarLink(
                                    $item,
                                    $item->first_name . ' ' . $item->last_name,
                                    'deals.show')
                            ],
                            ['label' => 'Email', 'field' => 'email'],
                            ['label' => 'Phone Number', 'field' => 'phone'],
                            ['label' => 'Lead Status', 'field' => 'lead_status'],
                        ]"
                    />
                @endif

            </div>

            <!-- Associated Deals -->
            <div class="mb-8 border p-4 rounded-xl border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Companies</h3>
                    <button class="text-blue-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($dealCompanies->isEmpty())
                    <p class="text-gray-500">No associated companies yet.</p>
                @else
                    <x-association-table
                        :items="$dealCompanies"
                        :columns="[
                            [
                                'label' => 'Company Name',
                                'callback' => fn($item) => avatarLink(
                                    $item,
                                    $item->name ,
                                    'companies.show'
                                )
                            ],
                            ['label' => 'Domain', 'field' => 'domain'],
                            ['label' => 'Industry', 'field' => 'industry'],
                            ['label' => 'Country/Region', 'field' => 'country'],
                        ]"
                    />
                @endif
            </div>
        </main>
    </div>
</x-layout>


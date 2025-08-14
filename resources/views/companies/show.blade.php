<x-layout>
    <div class="flex w-full h-screen ">
        <!-- Sidebar -->
        <x-show-sidebar-card
            :entity="$company"
            type="Company"
            :fields="[
                'Owner' => $company->owner,
                'Industry' => $company->industry,
                'Country' => $company->country,
                'State' => $company->state,
                'Postal Code' => $company->postal_code,
            ]"
            :delete-route="route('companies.destroy', $company->id)"
        >
            <x-action-buttons />
        </x-sidebar-card>

        <!-- Main Content -->
        <main class="ml-80 overflow-y-auto flex-1 p-6 bg-white border border-black/20 rounded-xl mr-2">

            <!-- Tab and Company Info Grid -->
            <x-tab-info :items="[
                'Create Date' => $company->created_at->format('d M Y h:i A'),
                'Lifecycle Stage' => 'Lead',
                'Last Activity Date' => '--'
            ]" />

            <!-- Associated Contacts -->
            <div class="mb-8 border p-4 rounded-xl border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Contacts</h3>
                    <button class="text-blue-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($companyContacts->isEmpty())
                    <p class="text-gray-500">No associated contacts yet.</p>
                @else
                    <x-association-table
                        :items="$companyContacts"
                        :columns="[
                            [
                                'label' => 'Title',
                                'callback' => fn($item) => avatarLink(
                                    $item,
                                    $item->first_name . ' ' . $item->last_name,
                                    'contacts.show')
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
                    <h3 class="text-lg font-semibold">Associated Deals</h3>
                    <button class="text-blue-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($companyDeals->isEmpty())
                    <p class="text-gray-500">No associated deals yet.</p>
                @else
                    <x-association-table
                        :items="$companyDeals"
                        :columns="[
                            [
                                'label' => 'Title',
                                'callback' => fn($deal) => avatarLink(
                                    $deal,
                                    $deal->title,
                                    'deals.show')
                            ],
                            ['label' => 'Amount', 'field' => 'amount'],
                            ['label' => 'Status', 'field' => 'status'],
                            ['label' => 'Close Date', 'field' => 'close_date'],
                        ]"
                    />
                @endif
            </div>
        </main>
    </div>
</x-layout>

<x-layout>
    <div class="flex w-full h-screen ">
        <!-- Sidebar -->
        <x-show-sidebar-card
            :entity="$contact"
            type="Contact"  
            :fields="[
                'Owner' => $contact->owner,
                'Name' => $contact->first_name . ' ' . $contact->last_name,
                'Email' => $contact->email,
                'Phone' => $contact->phone,
                'Lead Status' => $contact->lead_status,
            ]"
            :delete-route="route('contacts.destroy', $contact->id)">
            <x-action-buttons />
        </x-sidebar-card>

        <!-- Main Content -->
        <main class="ml-80 flex-1 p-6 overflow-y-auto bg-white border border-black/20 rounded-xl mr-2">
            <!-- Tab and Company Info Grid -->
            <x-tab-info :items="[
                'Create Date' => $contact->created_at->format('d M Y h:i A'),
                'Lifecycle Stage' => 'Lead',
                'Last Activity Date' => '--'
            ]" />

            <!-- Associated Contacts -->
            <div class="mb-8 border p-4 rounded-xl border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Companies</h3>
                    <button class="text-blue-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($contactCompanies->isEmpty())
                    <p class="text-gray-500">No associated companies yet.</p>
                @else
                    <x-association-table
                        :items="$contactCompanies"
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

            <!-- Associated Deals -->
            <div class="mb-8 border p-4 rounded-xl border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Deals</h3>
                    <button class="text-blue-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($contactDeals->isEmpty())
                    <p class="text-gray-500">No associated deals yet.</p>
                @else
                    <x-association-table
                        :items="$contactDeals"
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

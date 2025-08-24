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
                'Created At' => $deal->created_at->format('d M Y h:i A'),
                'Close Date' => $deal->close_date ? $deal->close_date->format('d M Y h:i A') : '',
            ]"
            :delete-route="route('deals.destroy', $deal->id)"
        >
            <x-action-buttons />
        </x-show-sidebar-card>


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
                    <button
                        class="bg-blue-500 text-white px-3 py-1 rounded-xl font-semibold hover:bg-blue-600 transition-colors duration-200"
                        onclick="openSidebar('contactSidebar')">
                        + Add
                    </button>
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
                                    'contacts.show')
                            ],
                            ['label' => 'Email', 'field' => 'email'],
                            ['label' => 'Phone Number', 'field' => 'phone'],
                            ['label' => 'Lead Status', 'field' => 'lead_status'],
                        ]"
                    />
                @endif

            </div>

            <!-- Associated Contacts -->
            <div class="mb-8 border p-4 rounded-xl border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Companies</h3>
                    <button
                        class="bg-blue-500 text-white px-3 py-1 rounded-xl font-semibold hover:bg-blue-600 transition-colors duration-200"
                        onclick="openSidebar('companySidebar')">
                        + Add
                    </button>
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
                                    $item->name,
                                    'companies.show')
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

    <x-add-association-sidebar
        id="contactSidebar"
        entity="Contact"
        :createRoute="route('contacts.store')"
        :linkRoute="route('deals.add.contacts', $deal->id)"
        :existingItems="$allContacts" {{-- Pass from controller --}}
        :parentId="$deal->id"
        parentType="deal"
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

    <x-add-association-sidebar
        id="companySidebar"
        entity="Company"
        :createRoute="route('companies.store')"
        :linkRoute="route('deals.add.companies', $deal->id)"
        :existingItems="$allCompanies"
        :parentId="$deal->id"
        parentType="deal"
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

    <x-edit-form
        entity="Deal"
        :route="route('deals.update', $deal->id)"
        method="PUT"
        :model="$deal"
        :allContacts="$allContacts"
        :allCompanies="$allCompanies"
        :fields="[
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'placeholder' => 'Enter deal title'],
            ['name' => 'amount', 'label' => 'Amount', 'type' => 'text', 'placeholder' => 'Enter deal amount'],
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


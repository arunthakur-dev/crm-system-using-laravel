<x-layout>
    <div class="flex space-x-8 p-6 bg-white rounded-lg shadow-md">

        <!-- Sidebar -->
        <aside class="w-80 flex-shrink-0">

            <!-- Header -->
            <div class="mb-6 relative group">
                <div class="flex items-center space-x-4">
                    @if ($company->logo)
                        <img src="" alt="Logo" class="w-20 h-20 object-cover rounded-md">
                    @else
                        <img src="https://via.placeholder.com/80" alt="Test Image" class="w-20 h-20 object-cover rounded-md">
                    @endif

                    <div>
                        <h2 class="text-xl font-semibold">{{ $company->name }}</h2>
                        <a href="http://{{ $company->company_domain }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                            {{ $company->company_domain }}
                        </a>
                        <p class="text-gray-500 mt-1">{{ $company->phone }}</p>
                    </div>
                </div>

                <!-- Edit button visible on hover -->
                <button class="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity bg-orange-500 text-white px-3 py-1 rounded text-sm">
                    Edit
                </button>
            </div>

            <!-- Actions -->
            <div class="flex justify-between space-x-2 mb-6">
                @foreach (['Note' => '🗒', 'Email' => '✉️', 'Call' => '📞', 'Task' => '✔️', 'Meeting' => '📅', 'More' => '⋮'] as $title => $icon)
                    <button title="{{ $title }}" class="bg-gray-100 hover:bg-gray-200 rounded p-2 text-lg">{{ $icon }}</button>
                @endforeach
            </div>

            <!-- About Section -->
            <section class="bg-gray-50 p-4 rounded shadow-sm space-y-4">
                <h3 class="font-semibold mb-3">About this company</h3>

                @php
                    $fields = [
                        'owner' => 'Owner',
                        'industry' => 'Industry',
                        'country' => 'Country',
                        'state' => 'State',
                        'postal_code' => 'Postal Code',
                        'employees' => 'Number of Employees',
                    ];
                @endphp

                @foreach ($fields as $field => $label)
                    <div>
                        <label class="block text-sm text-gray-700">{{ $label }}</label>
                        <div class="mt-1 text-gray-900">
                            {{ $company->$field ?? '--' }}
                        </div>
                    </div>
                @endforeach

                <!-- Delete Button -->
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="mt-6 text-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Delete Company
                    </button>
                </form>
            </section>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="border-b border-gray-200 mb-6">
                <button class="border-b-2 border-orange-500 pb-2 font-semibold text-gray-900">Overview</button>
            </div>

            <div class="grid grid-cols-3 gap-6 text-sm text-gray-700 mb-8">
                <div>
                    <strong>Create Date:</strong><br>
                    <hr class="my-1">
                    {{ $company->created_at->format('d M Y h:i A') }}
                </div>
                <div>
                    <strong>Lifecycle Stage:</strong><br>
                    <hr class="my-1">
                    Lead
                </div>
                <div>
                    <strong>Last Activity Date:</strong><br>
                    <hr class="my-1">
                    --
                </div>
            </div>

            <section class="mb-8">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Contacts</h3>
                    <button class="text-orange-500 font-semibold hover:underline" data-target="contactSidebar">+ Add</button>
                </div>

                @if ($companyContacts->isEmpty())
                    <p class="text-gray-500">No associated contacts yet.</p>
                @else
                    <div class="overflow-x-auto rounded border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($companyContacts as $contact)
                                    <tr>
                                        <td class="px-4 py-2 flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-orange-400 text-white flex items-center justify-center rounded-full font-semibold uppercase">
                                                {{ substr($contact->first_name, 0, 1) }}
                                            </div>
                                            <form method="POST" action="{{ route('contacts.show', $contact->id) }}">
                                                @csrf
                                                <button type="submit" class="text-left font-semibold hover:underline">
                                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2">{{ $contact->email ?? '--' }}</td>
                                        <td class="px-4 py-2">{{ $contact->phone ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <section>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold">Associated Deals</h3>
                    <button class="text-orange-500 font-semibold hover:underline" data-target="dealSidebar">+ Add</button>
                </div>

                @if ($companyDeals->isEmpty())
                    <p class="text-gray-500">No associated deals yet.</p>
                @else
                    <div class="overflow-x-auto rounded border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Close Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deal Stage</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($companyDeals as $deal)
                                    <tr>
                                        <td class="px-4 py-2 flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-orange-400 text-white flex items-center justify-center rounded-full font-semibold uppercase">
                                                {{ strtoupper(substr($deal->title ?? '', 0, 1)) }}
                                            </div>
                                            <form method="POST" action="{{ route('deals.show', $deal->id) }}">
                                                @csrf
                                                <button type="submit" class="text-left font-semibold hover:underline">
                                                    {{ $deal->title ?? '' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-2">{{ $deal->amount ?? '--' }}</td>
                                        <td class="px-4 py-2">{{ optional($deal->close_date)->format('d M Y') ?? '--' }}</td>
                                        <td class="px-4 py-2">{{ $deal->deal_stage ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    </div>
</x-layout>

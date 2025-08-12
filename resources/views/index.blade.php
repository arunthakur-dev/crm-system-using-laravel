<x-layout>
    @guest
        <div class="flex flex-col items-center justify-center text-center min-h-[70vh]">
            <div class="bg-amber-50 border border-r p-20 rounded-lg shadow-lg">
            <h1 class="text-4xl font-bold mb-4 p-4">Welcome to CRM System</h1>
            <p class="text-lg text-gray-600 max-w-2xl mb-8 p-4">
                Manage your contacts, deals, and companies all in one place.
                Our CRM system is designed to streamline your workflow,
                improve collaboration, and help you close more deals.
            </p>

            <div class="space-x-15 mt-8 p-4">
                <a href="/register"
                   class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                    Sign Up
                </a>
                <a href="/login"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Log In
                </a>
            </div>
            </div>
        </div>
    @endguest

    @auth
        <div class="mx-20 border border-black/20 rounded-2xl mb-10 overflow-hidden">
        <div class="bg-gray-200 items-center justify-center text-center border-b border-black/20 py-5">
            <h1 class="text-4xl font-semibold">
                Welcome, <strong>{{ auth()->user()->name }}</strong>
            </h1>
        </div>

        <div class="p-6">
            <!-- First row: 2 sections side-by-side -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Section 1 -->
                <section class="border border-black/20 rounded-lg p-6">
                    <x-section-heading>Recent Contacts</x-section-heading>
                    <div class="mt-6 space-y-4">
                        @forelse ($recentContacts as $contact)
                            <div class="border border-black/20 p-4 rounded-lg shadow w-full">
                                <h3 class="font-bold">Name: {{ $contact->first_name }} {{ $contact->last_name }}</h3>
                                <p><strong>Email:</strong> {{ $contact->email }}  |  <strong>Phone:</strong> {{ $contact->phone }}</p>
                            </div>
                        @empty
                            <div class="border border-black/20 p-4 rounded-lg shadow text-center">
                                <h3 class="font-bold">No contacts found.</h3>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- Section 2 -->
                <section class="border border-black/20 rounded-lg p-6">
                    <x-section-heading>Recent Deals</x-section-heading>
                    <div class="mt-6 space-y-4">
                        @forelse ($recentDeals as $deal)
                            <div class="border border-black/20 p-4 rounded-lg shadow w-full">
                                <h3 class="font-bold">Title: {{ $deal->title }}</h3>
                                <p><strong>Amount:</strong> ${{ number_format($deal->amount, 2) }}  |  <strong>Status:</strong> {{ $deal->status }}</p>
                            </div>
                        @empty
                            <div class="border border-black/20 p-4 rounded-lg shadow text-center">
                                <h3 class="font-bold">No deals found.</h3>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Second row: 1 section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <section class="border border-black/20 rounded-lg p-6">
                    <x-section-heading>Recent Companies</x-section-heading>
                    <div class="mt-6 space-y-4">
                        @forelse ($recentCompanies as $company)
                            <div class="border border-black/20 p-4 rounded-lg shadow w-full">
                                <h3 class="font-bold">Company Name: {{ $company->name }}</h3>
                                <p><strong>Domain:</strong> {{ $company->domain }}  |  <strong>Country:</strong> {{ $company->country }}</p>
                            </div>
                        @empty
                            <div class="border border-black/20 p-4 rounded-lg shadow text-center">
                                <h3 class="font-bold">No companies found.</h3>
                            </div>
                        @endforelse
                    </div>
                </section>
                <div></div>
            </div>
        </div>
    </div>
    @endauth
</x-layout>

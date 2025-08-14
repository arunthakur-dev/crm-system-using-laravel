<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRM System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-black h-screen flex flex-col">
    @if(session('success'))
        <div id="success-message"
            class="fixed top-30 left-1/2 transform -translate-x-1/2 bg-green-50 text-black px-6 py-3 rounded-xl shadow-lg z-50 flex items-center space-x-4">

            <!-- Success Icon -->
            <div class="flex items-center justify-center w-8 h-8 bg-green-200 rounded-full">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Success Message -->
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('success-message').remove()"
                class="ml-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                &times;
            </button>
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) msg.remove();
            }, 3000);
        </script>
    @endif

    <!-- Container -->
    <div class="max-w-[1550px] mx-auto border border-black/20 flex flex-col flex-1">

        <!-- Navbar -->
        <nav class="fixed top-0 left-1/2 transform -translate-x-1/2 w-[1550px] bg-cyan-500 text-black/80 flex justify-between items-center px-4 py-4 z-50">
            <div>
                <a href="/"><img src="{{ Vite::asset('resources/images/logo.jpg') }}" alt="logo" class="h-12 w-16"></a>
            </div>

            @auth
            <div class="space-x-12 text-[22px] font-semibold flex items-center text-white">
                <x-nav-link href="/" :active="request()->is('/')">Dashboard</x-nav-link>
                <x-nav-link href="/companies" :active="request()->is('companies')">Companies</x-nav-link>
                <x-nav-link href="/contacts" :active="request()->is('contacts')">Contacts</x-nav-link>
                <x-nav-link href="/deals" :active="request()->is('deals')">Deals</x-nav-link>
            </div>
            <div class="space-x-10 font-bold flex">
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">Log Out</button>
                </form>
            </div>
            @endauth
        </nav>


        <!-- Main Content -->
        <main class="mt-28 mb-28 w-[1550px] mx-auto flex-1">
            {{ $slot }}
        </main>


        <footer class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-[1550px] bg-cyan-500 text-white text-center py-6 z-50">
            <p>&copy; {{ date('Y') }} CRM System. All rights reserved.</p>
        </footer>


    </div>

</body>
</html>

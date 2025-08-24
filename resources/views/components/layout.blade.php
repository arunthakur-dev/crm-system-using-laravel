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
    @php
        $successMessage = session('success');
        $infoMessage = session('info');

        $message = $successMessage ?? $infoMessage;
        $type = $successMessage ? 'success' : ($infoMessage ? 'info' : null);
    @endphp

    @if($message)
        <div id="flash-message"
            class="fixed top-30 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-xl shadow-lg z-50 flex items-center space-x-4
                {{ $type === 'success' ? 'bg-green-50 text-black' : 'bg-blue-50 text-black' }}">

            <!-- Icon -->
            <div class="flex items-center justify-center w-8 h-8 rounded-full
                {{ $type === 'success' ? 'bg-green-200' : 'bg-blue-200' }}">
                @if($type === 'success')
                    <!-- Checkmark icon -->
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    <!-- Exclamation mark icon for info -->
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                @endif
            </div>

            <!-- Message -->
            <span>{{ $message }}</span>

            <!-- Close button -->
            <button onclick="document.getElementById('flash-message').remove()"
                class="ml-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                &times;
            </button>
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if (msg) msg.remove();
            }, 3000);
        </script>
    @endif


    <!-- Container -->
    <div class="max-w-[1550px] mx-auto border border-black/20 flex flex-col flex-1">

        <!-- Navbar -->
        <nav class="fixed top-0 left-1/2 transform -translate-x-1/2 w-[1550px] bg-cyan-500 text-black/80 flex justify-between items-center px-4 py-4 z-50">
            <div>
                <a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-16"></a>
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
            @guest
                <div class="space-x-4 font-bold py-3">
                    <x-nav-link href="/register" :active="request()->is('register')">Sign Up</x-nav-link>
                    <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
                </div>
            @endguest
        </nav>

        <!-- Main Content -->
        <main class="mt-28 mb-28 w-[1550px] mx-auto flex-1">
            {{ $slot }}
        </main>


        <footer class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-[1550px] bg-cyan-500 text-white text-center py-6 z-40">
            <p>&copy; {{ date('Y') }} CRM System. All rights reserved.</p>
        </footer>


    </div>

    <!-- Global Edit Sidebar -->
    <div id="editSidebar"
        class="fixed top-0 right-0 w-96 h-full bg-white border-l border-gray-200 shadow-lg transform translate-x-full transition-transform duration-300 z-50">

        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-semibold">Edit</h2>
            <button onclick="closeEntitySidebar()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <div id="editSidebarContent" class="p-4">
            <!-- Form will be loaded here -->
        </div>
    </div>
</body>
</html>

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

<body class="text-black min-h-screen flex flex-col border">

    <!-- Container -->
    <div class="w-full max-w-[1550px] mx-auto border border-black/20 flex flex-col flex-1">

        <!-- Navbar -->
        <div class="border border-black/20">
            <nav class="bg-cyan-500 text-black/80 flex justify-between items-center px-4 py-4">
                <div>
                    <a href="/">
                        <img src="{{ Vite::asset('resources/images/logo.jpg') }}" alt="logo" class="h-12 w-16">
                    </a>
                </div>

                <div class="space-x-12 text-[22px] font-semibold font-2xl flex items-center text-white">
                    <x-nav-link href="/" :active="request()->is('/')">Dashboard</x-nav-link>
                    <x-nav-link href="/companies" :active="request()->is('companies')">Companies</x-nav-link>
                    <x-nav-link href="/contacts" :active="request()->is('contacts')">Contacts</x-nav-link>
                    <x-nav-link href="/deals" :active="request()->is('deals')">Deals</x-nav-link>
                </div>

                @auth
                    <div class="space-x-10 font-bold flex">
                        <form method="POST" action="/logout">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                                Log Out
                            </button>
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
        </div>

        <!-- Main Content -->
        <main class="mt-10 w-full flex-1 px-10">
            {{ $slot }}
        </main>


        <!-- Footer -->
        <footer class="bg-cyan-500 text-white text-center py-6 mt-auto font-b">
            <p>&copy; {{ date('Y') }} CRM System. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>

<x-layout>
    <div class="flex justify-center items-center mb-10">
        <div class="border border-black/20 p-10 rounded-lg shadow-lg w-full max-w-2xl">
            <x-page-heading>Log In</x-page-heading>

            <div class="mt-10">
                <x-forms.divider />
                <x-forms.form method="POST" action="/login">
                    <x-forms.input label="Email" name="email" type="email" />
                    <x-forms.input label="Password" name="password" type="password" />

                    <x-forms.divider />
                    <x-forms.button>Log In</x-forms.button>

                    <div class="mt-2">
                        Doesn't have an account? <a href="/register" class="text-blue-600 hover:underline">Register here</a>
                    </div>
                </x-forms.form>
            </div>
        </div>
    </div>
</x-layout>

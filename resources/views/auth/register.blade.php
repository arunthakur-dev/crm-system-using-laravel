<x-layout>
    <div class="flex justify-center items-center mb-10">
        <div class="border border-black/20 p-10 rounded-lg shadow-lg w-full max-w-2xl">
            <x-page-heading>Register</x-page-heading>

            <div class="mt-10">
                <x-forms.divider />
                <x-forms.form method="POST" action="/register" enctype="multipart/form-data">
                    <x-forms.input label="Name" name="name"  />
                    <x-forms.input label="Email" name="email" type="email"  />
                    <x-forms.input label="Password" name="password" type="password"  />
                    <x-forms.input label="Password Confirmation" name="password_confirmation" type="password"  />

                    <x-forms.divider />

                    <x-forms.button>Create Account</x-forms.button>
                    <div>
                        Already have an account? <a href="/login" class="text-blue-600 hover:underline">login here</a>
                    </div>
                </x-forms.form>
            </div>
        </div>
    </div>
</x-layout>

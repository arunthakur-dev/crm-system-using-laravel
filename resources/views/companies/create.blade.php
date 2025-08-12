@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-3xl mb-6 font-semibold">Add New Company</h1>

    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block font-medium">Company Name</label>
            <input type="text" name="name" id="name" class="border p-2 w-full rounded" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="domain" class="block font-medium">Domain</label>
            <input type="text" name="domain" id="domain" class="border p-2 w-full rounded" value="{{ old('domain') }}">
            @error('domain')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block font-medium">Phone</label>
            <input type="text" name="phone" id="phone" class="border p-2 w-full rounded" value="{{ old('phone') }}">
            @error('phone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo" class="block font-medium">Company Logo</label>
            <input type="file" name="logo" id="logo" class="border p-2 w-full rounded" accept="image/*">
            @error('logo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Create Company</button>
    </form>
</div>
@endsection

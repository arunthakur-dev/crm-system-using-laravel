@props([
    'entity',
    'fields' => [],
    'deleteRoute' => null,
    'type' => null, // optional; will auto-infer if not passed
])
@php
    // Infer the type if not provided: App\Models\Contact => "Contact"
    $type = $type ?? class_basename($entity);
@endphp

<aside class="fixed mt-0 bg-white border rounded-xl border-gray-200 shadow-lg w-80 h-full p-4">
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-6">
        {{-- Company --}}
        @if ($type === 'Company')
            <div class="flex-shrink-0">
                @if (!empty($entity->logo))
                    <img src="{{ asset('uploads/logos/' . $entity->logo) }}" alt="Company Logo" class="w-20 h-20 rounded object-cover border">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Default Logo" class="w-20 h-20 rounded object-cover border">
                @endif
            </div>
            <div>
                <h2 class="text-xl font-semibold">{{ $entity->name ?? 'Untitled Company' }}</h2>
                @if (!empty($entity->domain))
                    <a href="http://{{ $entity->domain }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                        {{ $entity->domain }}
                    </a>
                @endif
                @if (!empty($entity->phone))
                    <p class="text-gray-600 text-sm">{{ $entity->phone }}</p>
                @endif
            </div>

        {{-- Contact --}}
        @elseif ($type === 'Contact')
            <div class="flex-shrink-0">
                @if (!empty($entity->logo))
                    <img src="{{ asset('uploads/logos/' . $entity->logo) }}" alt="Contact Logo" class="w-20 h-20 rounded object-cover border">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="Default Logo" class="w-20 h-20 rounded object-cover border">
                @endif
            </div>
            <div>
                <h2 class="text-xl font-semibold">
                    {{ trim(($entity->first_name ?? '') . ' ' . ($entity->last_name ?? '')) ?: 'Untitled Contact' }}
                </h2>
                @if (!empty($entity->email))
                    <a href="mailto:{{ $entity->email }}" class="text-blue-600 hover:underline text-sm">
                        {{ $entity->email }}
                    </a>
                @endif
                @if (!empty($entity->phone))
                    <p class="text-gray-600 text-sm">{{ $entity->phone }}</p>
                @endif
            </div>

        {{-- Deal (no logo) --}}
        @elseif ($type === 'Deal')
            <div>
                <h2 class="text-xl border-b border-black/20 pb-4 font-semibold">{{ $entity->title ?? 'Untitled Deal' }}</h2>
                @if (!empty($entity->amount))
                    <p class="text-gray-700 text-sm"><strong>Amount:</strong> {{ $entity->amount }}</p>
                @endif
                @if (!empty($entity->close_date))
                    <p class="text-gray-700 text-sm">
                        <strong>Close Date:</strong> {{ \Illuminate\Support\Carbon::parse($entity->close_date)->format('d M Y') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Action Buttons Slot -->
    {{ $slot }}

    <!-- Details -->
    <section class="mt-2">
        <h3 class="font-semibold text-lg mt-2 text-gray-800 mb-4">
            About this {{ strtolower($type) }}
        </h3>
        <div class="space-y-4 text-sm">
            @foreach ($fields as $label => $value)
                <div>
                    <p class="text-gray-500">{{ $label }}</p>
                    <p class="text-gray-900 font-medium">{{ $value ?? '--' }}</p>
                </div>
            @endforeach
        </div>

        @if($deleteRoute)
            <form action="{{ $deleteRoute }}" method="POST" class="mt-8 " onsubmit="return confirm('Are you sure you want to delete this deal?');">
                @csrf
                @method('DELETE')
                <div class="justify-center items-center">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                        Delete {{ $type }}
                    </button>
                </div>
            </form>
        @endif
    </section>
</aside>

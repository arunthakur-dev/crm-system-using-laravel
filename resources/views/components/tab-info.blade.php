<div class="border-b border-gray-200 mb-6">
    <button class="border-b-2 border-orange-500 pb-2 font-semibold text-gray-900">
        Overview
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-8">
    @foreach ($items as $label => $value)
        <div>
            <strong>{{ $label }}:</strong>
            <hr class="my-1">
            {!! $value ?? '--' !!}
        </div>
    @endforeach
</div>

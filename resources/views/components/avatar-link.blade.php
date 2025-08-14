<div class="flex items-center space-x-3">
    <div class="w-8 h-8 bg-blue-500 text-white flex items-center justify-center rounded-full font-bold uppercase">
        {{ $initial() }}
    </div>
    <form method="POST" action="{{ route($routeName, $item->id) }}">
        @csrf
        <button type="submit" class="text-blue-600 font-semibold hover:underline">
            {{ $displayValue }}
        </button>
    </form>
</div>

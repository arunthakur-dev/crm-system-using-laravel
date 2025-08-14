@props(['name', 'label'])

<div class="inline-flex items-center">
    <span class="h-2 bg-white inline-block "></span>
    <label class="font-bold text-md w-full" for="{{ $name }}">{{ $label }}</label>
</div>

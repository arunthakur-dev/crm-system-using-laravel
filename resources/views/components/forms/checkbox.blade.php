@props(['label', 'label_1', 'name'])

@php
    $defaults = [
        'type' => 'checkbox',
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-md bg-black/5 border border-black/10 p-5',
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label  :$name>
    <div class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full">
        <input {{ $attributes($defaults) }}>
        <span class="pl-1">{{ $label_1 }}</span>
    </div>
</x-forms.field>

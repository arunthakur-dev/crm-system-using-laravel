@props(['label', 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-md bg-black/5 border border-black/10 px-5 py-3 w-full',
        'value' => old($name)
    ];
@endphp

<x-forms.field :label="$label" :name="$name">
    <input {{ $attributes->merge($defaults) }}>
</x-forms.field>

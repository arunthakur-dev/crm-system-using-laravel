<form {{ $attributes(["class" => "max-w-2xl mx-auto mb-50 space-y-6", "method" => "GET"]) }}>
    @if ($attributes->get('method', 'GET') !== 'GET')
        @csrf
        @method($attributes->get('method'))
    @endif

    {{ $slot }}
</form>

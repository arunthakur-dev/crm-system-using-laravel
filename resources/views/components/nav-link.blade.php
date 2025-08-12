<a class="{{  $active ? "bg-gray-900 text-white" : "text-black bg-gray-300 hover:bg-gray-700 hover:text-white"}} rounded-md px-3 py-2 text-base font-2xl"
    area-current="{{ $active ? "page" : 'false' }}"
{{ $attributes }}> {{ $slot}}</a>

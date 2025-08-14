<a class="{{  $active ? "bg-white text-black" : "text-white bg-gray-400 hover:bg-white hover:text-black"}} rounded-md px-3 py-2 text-base font-2xl"
    area-current="{{ $active ? "page" : 'false' }}"
{{ $attributes }}> {{ $slot}}</a>

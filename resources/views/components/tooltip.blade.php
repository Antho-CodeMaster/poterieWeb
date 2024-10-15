@props([
    'id',
    'text',
    'position' => 'top'
])
@php
if (!function_exists('positionClasses')) {
    function positionClasses($position) {
        switch ($position) {
            case 'bottom':
                return 'mt-2 top-full left-1/2 transform -translate-x-1/2';
            case 'left':
                return 'mr-2 right-full top-1/2 transform -translate-y-1/2';
            case 'right':
                return 'ml-2 left-full top-1/2 transform -translate-y-1/2';
            case 'top':
            default:
                return 'mb-2 bottom-full left-1/2 transform -translate-x-1/2';
        }
    }
}

@endphp

<span class="relative group" id="{{$id}}">


    <!-- element qui active le tooltip-->
    {{ $slot }}

    <!-- Tooltip content -->
    <div class="absolute bg-hoverBeige text-xs rounded-md p-2 shadow-lg sm:w-[100px] md:w-[150px] w-[250px]
    invisible opacity-0 group-hover:visible group-hover:opacity-100 transition duration-200 ease-in-out
    {{ positionClasses($position) }}">
        {!! $text !!}
    </div>


</span>


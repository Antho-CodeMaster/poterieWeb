@php
    $p = $p ?? '';
    $padding = ($p == '' ? 'px-2' : 'px-4')
@endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#FF0000] hover:bg-[#FA3D3D] flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        {{ $slot }}
        @if ($p != '')
            <p class="mr-1 my-auto text-[100%] text-[#FFBEBE]">{{ $p }}</p>
        @endif
    </div>
</button>

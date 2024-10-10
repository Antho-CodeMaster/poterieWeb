@php $padding = ($p == '' ? 'px-2' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#FA3D3D] hover:bg-[#FF0000] flex"]) }}>
    <div class="m-auto flex gap-2">
        {{ $slot }}
        @if ($p != '')
            <p class="mr-1 text-xl text-[#FFBEBE]">{{ $p }}</p>
        @endif
    </div>
</button>

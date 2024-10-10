@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#FA3D3D] hover:bg-[#FF0000] flex"]) }}>
    <div class="m-auto flex gap-2">
        @if ($slot != '')
            <p class="text-xl text-[#FFBEBE]">{{ $slot }}</p>
        @endif
    </div>
</button>

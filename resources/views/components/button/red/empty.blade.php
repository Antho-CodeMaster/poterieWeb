@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#FF0000] hover:bg-[#FA3D3D] flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        @if ($slot != '')
            <p class="my-auto text-[100%] text-[#FFBEBE] font-medium">{{ $slot }}</p>
        @endif
    </div>
</button>

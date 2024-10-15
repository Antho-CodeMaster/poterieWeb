@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#009B4D] hover:bg-[#34af71] flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        @if ($slot != '')
            <p class="my-auto text-[100%] text-[#C1EFD7]">{{ $slot }}</p>
        @endif
    </div>
</button>

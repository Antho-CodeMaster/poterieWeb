@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#E6AF00] hover:bg-[#e6c200] flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        @if ($slot != '')
            <p class="my-auto text-[100%] text-[#fff4d2] font-medium">{{ $slot }}</p>
        @endif
    </div>
</button>

@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#73BCFF] hover:bg-[#8DC7FB] flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        @if ($slot != '')
            <p class="mr-1 my-auto text-[100%] text-[#3779A9]">{{ $slot }}</p>
        @endif
    </div>
</button>

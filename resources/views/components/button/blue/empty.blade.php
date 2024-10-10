@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#8DC7FB] hover:bg-[#73BCFF] flex"]) }}>
    <div class="m-auto flex gap-2">
        @if ($slot != '')
            <p class="text-xl text-[#3779A9]">{{ $slot }}</p>
        @endif
    </div>
</button>

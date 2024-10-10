@php $padding = ($p == '' ? 'px-2' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded bg-[#8DC7FB] hover:bg-[#73BCFF] flex"]) }}>
    <div class="m-auto flex gap-2">
        {{ $slot }}
        @if ($p != '')
            <p class="mr-1 text-xl text-[#3779A9]">{{ $p }}</p>
        @endif
    </div>
</button>

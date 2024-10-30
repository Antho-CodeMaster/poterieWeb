@php $padding = ($p == '' ? 'px-2' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding shadow-inner rounded border border-[#444444] flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        {{ $slot }}
        @if ($p != '')
            <p class="mr-1 my-auto text-[100%] text-[#444444] font-medium">{{ $p }}</p>
        @endif
    </div>
</button>

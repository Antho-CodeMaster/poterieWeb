@php $padding = ($slot == '' ? 'px-5' : 'px-4') @endphp
<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "h-10 w-fit $padding flex"]) }}>
    <div class="h-full m-auto flex gap-2">
        @if ($slot != '')
            <p class="my-auto text-[100%] text-[#444444]">{{ $slot }}</p>
        @endif
    </div>
</button>

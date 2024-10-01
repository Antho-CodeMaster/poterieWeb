<div x-cloak x-data="{ openAvertir: {{ $errors->any() ? 'true' : 'false' }} }" @close-avertir-modal.window="openAvertir = false">
    <button @click="openAvertir = true; $dispatch ('open-avertir-modal'); $dispatch('set-id', {{$id}});" class="h-10 w-fit px-4 shadow-inner rounded bg-[#FA3D3D] hover:bg-[#FF0000] flex">
        <div class="m-auto flex gap-2">
            <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="#FFBEBE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <p class="text-xl text-[#FFBEBE]">Avertir</p>
        </div>
    </button>
</div>

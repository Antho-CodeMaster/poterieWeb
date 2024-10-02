<div x-cloak x-data="{ openDelete: {{ $errors->any() ? 'true' : 'false' }} }">
<button @click="openDelete = true; $dispatch ('open-delete-modal'); $dispatch('set-id', {{$id}}); $dispatch('set-name', {{$name}});" class="h-10 w-fit px-4 shadow-inner rounded bg-[#FA3D3D] hover:bg-[#FF0000] flex">
    <div class="m-auto flex gap-2">
        <svg class="w-6 h-6 my-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="#FFBEBE" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
            </svg>
        <p class="text-xl text-[#FFBEBE]">Supprimer</p>
    </div>
</button>
</div>



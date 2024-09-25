<x-app-layout>
    <div class="flex">
        @include('admin.menu-gauche')
        <div class="pt-20 pl-20 w-[80%]">
            <h1 class="text-4xl text-black">Utilisateurs</h1>
            <h2 class="text-2xl text-darkGrey">{{ sizeof($users) }} résultats</h2>
            <div class="flex flex-wrap h-[100%] gap-x-24 gap-y-10">
                @foreach ($users as $user)
                    <div class="w-[20%] h-[40%] bg-lightGrey rounded-[14px] flex flex-col">
                        <h3 class="text-2xl mx-auto my-auto">{{ $user->name }}</h3>
                        @include('admin.components.page-access-button')
                        <div class="flex">
                            @include('admin.components.avertir-button')
                            @include('admin.components.delete-button')
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

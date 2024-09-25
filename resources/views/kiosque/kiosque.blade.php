<x-app-layout>
    {{-- Section Bannière --}}
    <section>
        {{-- Nom d'artiste --}}
        <div>
            {{$artiste->nom_artiste}}
        </div>

        {{-- Photo de profil --}}
        <div>
            <img src="img/{{$artiste->path_photo_profil}}" alt="photo de profil" class="w-[150px] h-[150px] rounded-[100px]">
        </div>

        {{-- Réseaux sociaux --}}
        <div>

        </div>
    </section>
</x-app-layout>

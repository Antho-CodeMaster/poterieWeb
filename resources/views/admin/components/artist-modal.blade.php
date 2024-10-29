<div x-cloak @open-artist-modal.window="openArtist = true;">
    <div x-show="openArtist" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div x-data = "{name : '', link: '', artist : {}, src : ''}" @set-name.window="name = $event.detail"
            @set-link.window="link = $event.detail" @set-artist.window="artist = JSON.parse($event.detail)" @set-src.window="src = $event.detail"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="openArtist = false; console.log(artist.nom_artiste)"
                class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>
            <h2 class="w-[95%] text-left text-xl font-bold mb-6">Profil d'artiste de <span x-text="name">l'utilisateur</span>
            </h2>
            <p>Nom d'artiste: <span x-text="artist.nom_artiste ? artist.nom_artiste : 'N/A'"></span></p>
            <img :src="src" alt="Photo de profil de l'artiste" class="mx-auto">
            <p>Description: <span x-text="artist.description ? artist.description : 'N/A'"></span></p>
            <p>Type: <span x-text="artist.is_etudiant ? 'Étudiant' : 'Professionnel'"></span></p>
            <p>Artiste depuis le: <span x-text="artist.created_at.split('T')[0]"></span></p>

            <x-button.blue.leave class="mx-auto mt-4" @click="window.location.href=link">
                Voir le kiosque</x-button.blue.leave>
        </div>
    </div>
</div>

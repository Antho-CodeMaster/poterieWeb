<footer class="z-100 h-[30px] w-[100%] bg-[#c5af9b] flex text-[#444444] smallText justify-between items-center px-4">

    {{-- Informations générales --}}
    <p class="text-[#444444]">Site web créé par
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="hover:underline">HANS</a>
    </p>

    <div class="flex items-center font-size-[10px] justify-evenly sm:gap-4">

        {{-- Nous contacter --}}
        <div class="hover:underline text-[#444444]">
            <a href="{{ route('contact') }}">Nous contacter</a>
        </div>

        {{-- Besoin d'aide --}}
        <div class="hover:underline text-[#444444]">
            <a href="{{ route('apropos') }}">À propos de nous</a>
        </div>

        {{-- Conditions d'utilisation --}}
        <div class="hover:underline text-[#444444]">
            <a href="{{ route('conditions') }}">Conditions d'utilisation</a>
        </div>

        {{-- Politique de confidentialité --}}
        <div class="hover:underline text-[#444444]">
            <a href="{{ route('politique') }}">Politique de confidentialité</a>
        </div>
    </div>

</footer>

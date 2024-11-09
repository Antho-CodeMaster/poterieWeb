<footer class="z-50 h-[25px] w-[100%] bg-darkGrey flex text-[beige] smallText justify-between items-center   ">

    {{-- Informations générale --}}
    <div class="mx-[16px]">
        Site web créé par
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="underline">HANS</a>
    </div>

    <div class="flex items-center font-size-[10px]">

        {{-- Nous contacter --}}
        <div class="mx-[16px] underline">
            <a href="{{ route('contact') }}">Nous contacter</a>
        </div>

        {{-- Besoin d'aide --}}
        <div class="mx-[16px] underline">
            <a href="{{ route('apropos') }}">À propos de nous</a>
        </div>

        {{-- Conditions d'utilisateur --}}
        <div class="mx-[16px] underline">
            <a href="{{ route('decouverte') }}">Conditions d'utilisation</a>
        </div>
    </div>

</footer>

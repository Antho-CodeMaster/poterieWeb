<footer class="z-50 fixed bottom-0 w-[100%] bg-darkGrey flex text-[beige] smallText justify-between items-center   ">

    {{-- Informations générale --}}
    <div class="mx-[16px]">
        Site web créée par la
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="underline">HANS corporation</a>
    </div>

    <div class="flex items-center font-size-[10px]">
        {{-- Nous contacter --}}
        <div class="mx-[16px] underline">
            <a href="{{ route('decouverte') }}">Nous contacter</a>
        </div>

        {{-- Besoin d'aide --}}
        <div class="mx-[16px] underline">
            <a href="{{ route('decouverte') }}">Besoin d'aide?</a>
        </div>

        {{-- Conditions d'utilisateur --}}
        <div class="mr-[16px] underline">
            <a href="{{ route('decouverte') }}">Conditions d'utilisateur</a>
        </div>
    </div>

</footer>

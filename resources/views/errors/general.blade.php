<x-app-layout>
    <div class="lg:content-height py-16 lg:px-12 flex flex-col justify-center">
        <h1 class="text-center titre1-dark">Oups !</h1>
        <p class="mt-10">Une erreur s'est produite. Cette page a été créée par des étudiants du Cégep de Sherbrooke, et
            nous sommes
            conscients que certaines erreurs peuvent se glisser dans l'utilisation de la page. Afin d'améliorer
            l'expérience utilisateur, nous serions heureux d'avoir des informations afin de résoudre la problématique et
            s'assurer qu'elle n'arrive pas à d'autres utilisateurs.</p>

        <p class="my-10">Merci de signaler cette erreur aux adresses courriel présentes sur <a
                href="{{ route('contact') }}" class="underline hover:text-blue-500">cette page</a>.</p>

        @if (config('app.debug') && isset($exception))
            <h2>Informations sur l'erreur (à mentionner si vous nous contactez) :</h2>


            <div class="my-10 border-2 border-black p-4 w-fit">
                <p><strong>Message :</strong> {{ $exception->getMessage() }}</p>
                <p><strong>Fichier :</strong> {{ $exception->getFile() }}</p>
                <p><strong>Ligne :</strong> {{ $exception->getLine() }}</p>
                <h3>Trace :</h3>
                <pre>{{ $exception->getTraceAsString() }}</pre>
            </div>
        @endif

        <p class="mt-10">Merci de nous aider à faire de ce site un succès!</p>
    </div>
</x-app-layout>

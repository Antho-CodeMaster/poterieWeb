<x-app-layout>
    <form action="{{ route('abonnement') }}" method="post" enctype="multipart/form-data"
        class="content-height py-16 px-12 flex flex-col justify-center">
        @csrf
        <div class="w-1/2 py-4 px-12 mx-auto">
            <h1 class="text-center text-5xl">Payer votre abonnement</h1>
            <p>Le site a pour mission d'encourager et aider les étudiants en métiers d'art à vendre leurs
                oeuvres, car le processus peut être difficile. Ainsi, les vendeurs n'étant pas à l'école doivent
                payer un abonnement pour avoir accès au site.</p>
        </div>
        <div>
            <x-button.green.pay class="mx-auto mt-6">Payer</x-button.green.pay>
        </div>
        <div class="fixed bottom-10 right-5">
            @if ($errors->has('alreadySubscribed'))
                <div class="w-fit">
                    @include('messages.messageError', [
                        'message' => $errors->first('alreadySubscribed'),
                        'titre' => 'Déjà abonné !',
                    ])
                </div>
            @endif
        </div>
    </form>

</x-app-layout>

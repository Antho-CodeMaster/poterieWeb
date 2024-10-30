<x-app-layout>
    <form action="{{ route('store-demande-artiste') }}" method="post" enctype="multipart/form-data"
        class="content-height py-16 px-12 flex flex-col justify-center">
        @csrf
        <h1 class="text-center text-5xl">Devenir artiste-vendeur chez Terracium</h1>
        <div class="flex mt-20">
            <div class="w-1/2 py-4 px-12">
                <h2 class="text-center text-2xl mb-4">Étape 1</h2>
                <p class="text-center">Pour pouvoir vendre sur le site et avoir un kiosque, vous devez soumettre des
                    photos de vos créations. Cette étape nous permet d'éviter les faux comptes sur le site et nous
                    permet de nous assurer que les oeuvres vendues sont réelles et de qualité pour la plateforme.
                </p>
                <p class="text-center {{ $errors->has('photo-preuve') ? 'text-red-500 font-bold' : '' }}"
                    id="nb-photo-msg">Vous devez soumettre entre 1 et 10 photos.</p>

                <x-button.blue.add-pic class="mx-auto mt-6" type="button"
                    id="add-photo-preuve">Téléverser</x-button.blue.add-pic>

                <input id="photo-preuve" name="photo-preuve[]" type="file" multiple="multiple" class="hidden"
                    accept="image/jpeg, image/jpg, image/png">
                @for ($i = 0; $i < 10; $i++)
                    <div id="img-{{ $i }}" class="hidden justify-center">
                        <p class="my-auto mr-2">Image {{ $i + 1 }}</p>
                        <button type="button" id="remove-img-{{ $i }}"
                            class=" text-red-500 hover:text-red-600 leading-8 text-4xl">
                            &times;
                        </button>
                    </div>
                @endfor
            </div>

            <div class="w-1/2 py-4 px-12 border-l-2 border-black">
                <h2 class="text-center text-2xl mb-4">Étape 2</h2>
                <div class="justify-center flex">
                    <p class="my-auto">J'aimerais devenir vendeur en tant que : </p>
                    <select name="type" class="mx-4">
                        <option value="etu" {{ old('type') == 'etu' ? 'selected' : '' }}>Étudiant(e)</option>
                        <option value="pro" {{ old('type') == 'pro' ? 'selected' : '' }}>Professionnel(le)</option>
                    </select>
                    <svg id="info" class="cursor-pointer my-auto" width="30" height="30" viewBox="0 0 38 38"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.058 14.976C14.0754 14.3141 14.224 13.6622 14.4952 13.0582C14.7664 12.4541 15.1548 11.9099 15.6378 11.457C16.1209 11.0041 16.689 10.6516 17.3093 10.4199C17.9295 10.1882 18.5896 10.082 19.2513 10.1072C19.9129 10.1325 20.563 10.2888 21.1638 10.5672C21.7646 10.8455 22.3042 11.2403 22.7513 11.7287C23.1984 12.2171 23.5441 12.7894 23.7684 13.4124C23.9927 14.0354 24.0911 14.6967 24.058 15.358C24.0483 16.0078 23.909 16.6491 23.6482 17.2443C23.3874 17.8395 23.0104 18.3767 22.5393 18.8243C22.0683 19.272 21.5125 19.621 20.9048 19.8511C20.297 20.0811 19.6494 20.1875 19 20.164V23M18.98 29.016H19M37 19C37 21.3638 36.5344 23.7044 35.6298 25.8883C34.7252 28.0722 33.3994 30.0565 31.7279 31.7279C30.0565 33.3994 28.0722 34.7252 25.8883 35.6298C23.7044 36.5344 21.3638 37 19 37C16.6362 37 14.2956 36.5344 12.1117 35.6298C9.92784 34.7252 7.94353 33.3994 6.27208 31.7279C4.60062 30.0565 3.27475 28.0722 2.37017 25.8883C1.46558 23.7044 1 21.3638 1 19C1 14.2261 2.89642 9.64773 6.27208 6.27208C9.64773 2.89642 14.2261 1 19 1C23.7739 1 28.3523 2.89642 31.7279 6.27208C35.1036 9.64773 37 14.2261 37 19Z"
                            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div id="infobubble"
                    class="hidden absolute right-16 mt-2 bg-white border border-black w-[350px] rounded-lg p-5 text-center">
                    <p>Le site a pour mission d'encourager et aider les étudiants en métiers d'art à vendre leurs
                        oeuvres, car le processus peut être difficile. Ainsi, les vendeurs n'étant pas à l'école doivent
                        payer un abonnement pour avoir accès au site.</p>
                </div>
                <div id="variable-message-etu">
                    <p class="text-center mt-10">Puisque vous appliquez en tant qu'étudiant(e), veuillez soumettre une
                        photo pour chacune des
                        preuves suivantes: </p>
                    <ul class="list-disc ml-[40%]">
                        <li>Votre carte étudiante</li>
                        <li>Vous (pour valider votre carte étudiante)</li>
                        <li>Votre horaire de la session (pour valider que vous avez des cours cette session)</li>
                    </ul>
                    <p id="i-nb-photo-msg"
                        class="mt-6 text-center {{ $errors->has('photo-identite') ? 'text-red-500 font-bold' : '' }}">
                        Vous devez donc soumettre 3 photos au total.</p>
                    <x-button.blue.add-pic class="mx-auto mt-6" type="button"
                        id="add-photo-identite">Téléverser</x-button.blue.add-pic>


                    <input id="photo-identite" name="photo-identite[]" type="file" multiple="multiple" class="hidden"
                        accept="image/jpeg, image/jpg, image/png">
                    @for ($i = 0; $i < 3; $i++)
                        <div id="i-img-{{ $i }}" class="hidden justify-center">
                            <p class="my-auto mr-2">Image {{ $i + 1 }}</p>
                            <button type="button" id="i-remove-img-{{ $i }}"
                                class=" text-red-500 hover:text-red-600 leading-8 text-4xl">
                                &times;
                            </button>
                        </div>
                    @endfor
                </div>
                <div id="variable-message-pro" class="hidden">
                    <p class="text-center mt-10">Puisque vous appliquez en tant que professionnel(le), <span
                            class="font-bold">le paiement d'un
                            abonnement sera requis.</span> Cet abonnement soutient les frais de maintenance de la
                        plateforme web.
                        Le mode de paiement utilisé sera celui que vous avez enregistré dans
                        Paramètres > Facturation. Vous serez facturés dès que votre demande sera approuvée. Si le
                        paiement ne passe pas, vous n'aurez pas votre accès artiste.</p>
                </div>
            </div>
        </div>
        <div>
            <x-button.green.send class="mx-auto mt-6">Envoyer</x-button.green.send>
            <p class="text-center mt-6">Vous serez notifiés lorsqu'un administrateur passera en revue votre profil.</p>
        </div>

        <div class="fixed bottom-10 right-5">
            {{-- Erreur de l'ajout des photos --}}
            @if ($errors->has('photo-identite'))
                <div class="w-fit">
                    @include('messages.messageError', [
                        'message' => $errors->first('photo-identite'),
                        'titre' => 'Photos',
                    ])
                </div>
            @endif

            @for ($i = 0; $i < 10; $i++)
                @if ($errors->has('photo-preuve.' . $i))
                    <div class="w-fit">
                        @include('messages.messageError', [
                            'message' => $errors->first('photo-preuve.' . $i),
                            'titre' => 'Photos',
                        ])
                    </div>
                @break
            @endif
        @endfor

        @for ($i = 0; $i < 3; $i++)
            @if ($errors->has('photo-identite.' . $i))
                <div class="w-fit">
                    @include('messages.messageError', [
                        'message' => $errors->first('photo-identite.' . $i),
                        'titre' => 'Photos',
                    ])
                </div>
            @break
        @endif
    @endfor

    @if ($errors->has('photo-preuve'))
        <div class="w-fit">
            @include('messages.messageError', [
                'message' => $errors->first('photo-preuve'),
                'titre' => 'Photos',
            ])
        </div>
    @endif

    {{-- Erreur de demande déjà effectuée mais en attente --}}
    @if ($errors->has('alreadyPending'))
        <div class="w-fit">
            @include('messages.messageError', [
                'message' => $errors->first('alreadyPending'),
                'titre' => 'Demande en attente',
            ])
        </div>
    @endif

    {{-- Si toute autre erreur --}}
    @if ($errors->has('msg'))
        <div class="w-fit">
            @include('messages.messageFail', [
                'message' => $errors->first('msg'),
                'titre' => 'Demande en attente',
            ])
        </div>
    @endif
</div>
</form>

</x-app-layout>

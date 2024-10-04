<x-app-layout>
    <div class="content-height py-16 px-12 flex flex-col justify-center">
        <h1 class="text-center text-5xl">Devenir artiste-vendeur chez Terracium</h1>
        <div class="flex mt-20">
            <div class="w-1/2 py-4 px-12">
                <h2 class="text-center text-2xl mb-4">Étape 1</h2>
                <p class="text-center">Pour pouvoir vendre sur le site et avoir un kiosque, vous devez soumettre des
                    photos de vos créations.
                </p>
                <p class="text-center" id="nb-photo-msg">Vous pouvez soumettre de 1 à 5 photos.</p>

                <button type="button" id="add-photo-preuve"
                    class="w-[200px] h-[40px] mt-6 shadow-inner rounded border border-[#3779A9] bg-[#8DC7FB] hover:bg-[#73BCFF] mx-auto flex">
                    <div class="m-auto flex gap-2">
                        <svg class="w-6 h-6 my-auto" width="100" height="102" viewBox="0 0 100 102" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_4003_32)">
                                <path
                                    d="M19.6667 8.64284C15.4769 8.64284 12.0833 12.0921 12.0833 16.3506V78.0127C12.0833 82.2712 15.4769 85.7205 19.6667 85.7205H45.0086C43.8863 83.3234 43.1033 80.7374 42.7203 78.0127H23.4583C21.3653 78.0127 19.6667 76.2862 19.6667 74.1588V64.1929C19.6667 63.1716 20.0647 62.1888 20.7775 61.4681L24.5692 57.6142C26.0517 56.1074 28.4521 56.1074 29.9308 57.6142L42.4167 70.3049L42.7721 69.9436C44.7666 57.0524 55.7141 47.1817 68.9583 47.1817C70.2475 47.1817 71.5101 47.3091 72.75 47.4903V34.9576C72.75 32.9151 71.9502 30.9532 70.5283 29.508L52.2217 10.901C50.7998 9.45577 48.8696 8.64284 46.86 8.64284H19.6667ZM46.2083 14.2505L67.0625 35.62H50C47.907 35.62 46.2083 33.8935 46.2083 31.7661V14.2505ZM42.4167 43.3278C44.5097 43.3278 46.2083 45.0543 46.2083 47.1817C46.2083 49.309 44.5097 51.0355 42.4167 51.0355C40.3237 51.0355 38.625 49.309 38.625 47.1817C38.625 45.0543 40.3237 43.3278 42.4167 43.3278ZM68.9583 54.8894C58.4896 54.8894 50 63.5183 50 74.1588C50 84.7994 58.4896 93.4282 68.9583 93.4282C79.4271 93.4282 87.9167 84.7994 87.9167 74.1588C87.9167 63.5183 79.4271 54.8894 68.9583 54.8894ZM68.9583 62.5972C71.0513 62.5972 72.75 64.3237 72.75 66.4511V70.3049H76.5417C78.6347 70.3049 80.3333 72.0315 80.3333 74.1588C80.3333 76.2862 78.6347 78.0127 76.5417 78.0127H72.75V81.8666C72.75 83.9939 71.0513 85.7205 68.9583 85.7205C66.8653 85.7205 65.1667 83.9939 65.1667 81.8666V78.0127H61.375C59.282 78.0127 57.5833 76.2862 57.5833 74.1588C57.5833 72.0315 59.282 70.3049 61.375 70.3049H65.1667V66.4511C65.1667 64.3237 66.8653 62.5972 68.9583 62.5972Z"
                                    fill="#3779A9" />
                            </g>
                            <defs>
                                <clipPath id="clip0_4003_32">
                                    <rect y="0.215118" width="100" height="101.641" rx="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p class="text-[#3779A9]">Téléverser</p>
                    </div>
                </button>

                <input id="photo-preuve" name="photo-preuve" type="file" multiple="multiple"
                class="hidden" accept="image/jpeg, image/jpg, image/png">
                @for ($i = 0; $i < 5; $i++)

                    <div id="img-{{ $i }}" class="hidden justify-center">
                        <p class="my-auto mr-2">image1.png</p>
                        <button id="remove-img-{{ $i }}" class=" text-red-500 hover:text-red-600 leading-8 text-4xl">
                            &times;
                        </button>
                    </div>
                @endfor
            </div>

            <div class="w-1/2 py-4 px-12 border-l-2 border-black">
                <h2 class="text-center text-2xl mb-4">Étape 2</h2>
                <div class="justify-center flex">
                    <p class="mr-4 my-auto">J'aimerais devenir vendeur en tant que : </p>
                    <select>
                        <option value="etu">Étudiant(e)</option>
                        <option value="pro">Professionnel(le)</option>
                    </select>
                </div>
                <div id="variable-message-etu">
                    <p class="text-center mt-10">Puisque vous appliquez en tant qu'étudiant(e), veuillez soumettre une
                        photo pour chacune des
                        preuves suivantes: </p>
                    <ul class="list-disc ml-[40%] mt-6">
                        <li>Votre carte étudiante</li>
                        <li>Votre horaire de la session</li>
                        <li>Vous (pour valider votre carte étudiante)</li>
                    </ul>
                    <a href="#"
                        class="max-w-[200px] h-[40px] mt-6 shadow-inner rounded border border-[#3779A9] bg-[#8DC7FB] hover:bg-[#73BCFF] mx-auto flex">
                        <div class="m-auto flex gap-2">
                            <svg class="w-6 h-6 my-auto" width="100" height="102" viewBox="0 0 100 102"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_4003_32)">
                                    <path
                                        d="M19.6667 8.64284C15.4769 8.64284 12.0833 12.0921 12.0833 16.3506V78.0127C12.0833 82.2712 15.4769 85.7205 19.6667 85.7205H45.0086C43.8863 83.3234 43.1033 80.7374 42.7203 78.0127H23.4583C21.3653 78.0127 19.6667 76.2862 19.6667 74.1588V64.1929C19.6667 63.1716 20.0647 62.1888 20.7775 61.4681L24.5692 57.6142C26.0517 56.1074 28.4521 56.1074 29.9308 57.6142L42.4167 70.3049L42.7721 69.9436C44.7666 57.0524 55.7141 47.1817 68.9583 47.1817C70.2475 47.1817 71.5101 47.3091 72.75 47.4903V34.9576C72.75 32.9151 71.9502 30.9532 70.5283 29.508L52.2217 10.901C50.7998 9.45577 48.8696 8.64284 46.86 8.64284H19.6667ZM46.2083 14.2505L67.0625 35.62H50C47.907 35.62 46.2083 33.8935 46.2083 31.7661V14.2505ZM42.4167 43.3278C44.5097 43.3278 46.2083 45.0543 46.2083 47.1817C46.2083 49.309 44.5097 51.0355 42.4167 51.0355C40.3237 51.0355 38.625 49.309 38.625 47.1817C38.625 45.0543 40.3237 43.3278 42.4167 43.3278ZM68.9583 54.8894C58.4896 54.8894 50 63.5183 50 74.1588C50 84.7994 58.4896 93.4282 68.9583 93.4282C79.4271 93.4282 87.9167 84.7994 87.9167 74.1588C87.9167 63.5183 79.4271 54.8894 68.9583 54.8894ZM68.9583 62.5972C71.0513 62.5972 72.75 64.3237 72.75 66.4511V70.3049H76.5417C78.6347 70.3049 80.3333 72.0315 80.3333 74.1588C80.3333 76.2862 78.6347 78.0127 76.5417 78.0127H72.75V81.8666C72.75 83.9939 71.0513 85.7205 68.9583 85.7205C66.8653 85.7205 65.1667 83.9939 65.1667 81.8666V78.0127H61.375C59.282 78.0127 57.5833 76.2862 57.5833 74.1588C57.5833 72.0315 59.282 70.3049 61.375 70.3049H65.1667V66.4511C65.1667 64.3237 66.8653 62.5972 68.9583 62.5972Z"
                                        fill="#3779A9" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_4003_32">
                                        <rect y="0.215118" width="100" height="101.641" rx="16"
                                            fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <p class="text-[#3779A9]">Téléverser</p>
                        </div>
                    </a>
                </div>
                <div id="variable-message-pro" class="hidden">
                    <p class="text-center mt-10">Puisque vous appliquez en tant que professionnel(le), le paiement d'un
                        abonnement sera requis. Vous serez facturés dès que votre demande sera approuvée. Si le paiement
                        ne passe pas, vous n'aurez pas votre accès artiste.</p>
                </div>
            </div>
        </div>
        <div>
            <x-primary-button>Envoyer</x-primary-button>
            <p class="text-center">Vous serez notifiés lorsqu'un administrateur passera en revue votre profil.</p>
        </div>
    </div>
</x-app-layout>

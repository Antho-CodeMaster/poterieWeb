<div x-cloak x-data="{{'openCommande' . $commande->id_commande}}: false }" @close-login-modal.window="{{'openCommande'.$commande->id_commande}} = false">
    <!-- Trigger Button for Login Modal -->
    <button @click="{{'openCommande' . $commande->id_commande}}" = true">
        <div class="ms-1">
            Détail
        </div>
    </button>

    <!-- Login Modal -->
    <div x-show="{{'openCommande' . $commande->id_commande}}" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="{{'openCommande' . $commande->id_commande}} = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>

            <h2 class="text-left text-xl font-bold mb-6">{{$commande->ville->ville}}</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Courriel')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div class="text-center my-8">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('Connexion') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center justify-center mb-4">
                    <hr class="w-full border-gray-300">
                    <span class="absolute bg-white px-3 text-gray-500">OU</span>
                </div>

                <!-- Sign Up Button that closes Login Modal and opens Register Modal -->
                <div class="text-center my-8">
                    <button @click.stop="{{"openCommande".$commande->id_commande}} = false; $dispatch('open-register-modal'); console.log('Dispatching open-register-modal')" class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('S’inscrire') }}
                    </button>
                </div>

                <!-- Placeholder for Google -->
                <div class="text-center my-8">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('Google') }}
                    </button>
                </div>

                <!-- Placeholder for Facebook -->
                <div class="text-center mt-4">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('Facebook') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

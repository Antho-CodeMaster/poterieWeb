<div x-cloak x-data="{ openRegister: {{ $errors->any() ? 'true' : 'false' }} }" @open-register-modal.window="openRegister = true">
    <!-- Register Modal -->
    <div x-show="openRegister" x-cloak
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="openRegister = false"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>

            <h2 class="text-left text-xl font-bold mb-6">S’inscrire</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4 text-left">
                    <x-input-label for="name" :value="__('Nom')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mb-4 text-left">
                    <x-input-label for="reg_email" :value="__('Courriel')" />
                    <x-text-input id="reg_email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4 text-left">
                    <x-input-label for="reg_password" :value="__('Mot de passe')" />
                    <x-text-input id="reg_password" class="block mt-1 w-full" type="password" name="password"
                        minlength="8" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4 text-left">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <input type="radio" name="conditions" required>
                    <label for="conditions">J'ai lu et j'accepte la <a class="text-blue-600 hover:underline" href="{{ route('politique') }}" target="_blank">politique de confidentialité</a> et les <a class="text-blue-600 hover:underline" href="{{ route('conditions') }}" target="_blank">conditions
                            d'utilisation</a>.</label>
                </div>
                <!-- Register Button -->
                <div class="text-center my-8">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('Créer un compte') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center justify-center mb-4">
                    <hr class="w-full border-gray-300">
                    <span class="absolute bg-white px-3 text-gray-500">OU</span>
                </div>

                <!-- Google Login -->
                <div class="text-center my-8">
                    <a class="w-64 py-2 mx-auto bg-[#444444] text-[#F4F0EC] rounded flex justify-center gap-4 items-center"
                        href="{{ route('login.google') }}">
                        <img class="w-8 h-8" src="https://pluspng.com/img-png/google-logo-png-open-2000.png" />
                        {{ __('Inscription Google') }}
                    </a>
                </div>
            </form>
            <!-- Sign Up Button that closes Login Modal and opens Register Modal -->
            <div class="text-center my-8">
                <button @click.stop="openRegister = false; $dispatch('open-login-modal')"
                    class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                    {{ __('Se connecter') }}
                </button>
            </div>
        </div>
    </div>
</div>

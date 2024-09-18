<!-- resources/views/components/login-modal.blade.php -->
<div x-data="{ open: false }">
    <!-- Trigger Button -->
    <button @click="open = true">
        <div class="ms-1">
            <svg width="24" height="34" viewBox="0 0 34 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 36.2857V39.1429C2 39.9006 2.31607 40.6273 2.87868 41.1632C3.44129 41.699 4.20435 42 5 42H29C29.7956 42 30.5587 41.699 31.1213 41.1632C31.6839 40.6273 32 39.9006 32 39.1429V36.2857C32 34.0124 31.0518 31.8323 29.364 30.2248C27.6761 28.6173 25.3869 27.7143 23 27.7143H11C8.61305 27.7143 6.32387 28.6173 4.63604 30.2248C2.94821 31.8323 2 34.0124 2 36.2857ZM26 10.5714C26 12.8447 25.0518 15.0249 23.364 16.6323C21.6761 18.2398 19.3869 19.1429 17 19.1429C14.6131 19.1429 12.3239 18.2398 10.636 16.6323C8.94821 15.0249 8 12.8447 8 10.5714C8 8.29814 8.94821 6.11797 10.636 4.51051C12.3239 2.90306 14.6131 2 17 2C19.3869 2 21.6761 2.90306 23.364 4.51051C25.0518 6.11797 26 8.29814 26 10.5714Z" stroke="#444444" stroke-width="3.8"/>
            </svg>
        </div>
    </button>

    <!-- Modal -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>

            <h2 class="text-left text-xl font-bold mb-6">Se connecter</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

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
                <div class="text-center mb-4">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('Connexion') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="flex items-center justify-center mb-4">
                    <hr class="w-full border-gray-300">
                    <span class="absolute bg-white px-3 text-gray-500">OU</span>
                </div>

                <!-- Sign Up Button -->
                <div class="text-center mb-4">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('S’inscrire') }}
                    </button>
                </div>

                <!-- Placeholder for Google and Facebook Login -->
                <div class="flex flex-col items-center space-y-4 mb-4">
                    <div class="bg-gray-200 w-64 h-10 flex items-center justify-center">
                        Google
                    </div>
                    <div class="bg-gray-200 w-64 h-10 flex items-center justify-center">
                        Facebook
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

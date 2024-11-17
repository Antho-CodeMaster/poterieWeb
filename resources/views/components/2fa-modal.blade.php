<div
    x-cloak
    x-data="{ open2fa: {{ $errors->any() ? 'true' : 'false' }} }"
    @close-2fa-modal.window="open2fa = false"
    @open-2fa-modal.window="open2fa = true"
>
    <!-- Trigger Button for 2fa Modal -->
    <button @click="open2fa = true">
        <div class="ms-1">
            <svg width="24" height="34" viewBox="0 0 34 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 36.2857V39.1429C2 39.9006 2.31607 40.6273 2.87868 41.1632C3.44129 41.699 4.20435 42 5 42H29C29.7956 42 30.5587 41.699 31.1213 41.1632C31.6839 40.6273 32 39.9006 32 39.1429V36.2857C32 34.0124 31.0518 31.8323 29.364 30.2248C27.6761 28.6173 25.3869 27.7143 23 27.7143H11C8.61305 27.7143 6.32387 28.6173 4.63604 30.2248C2.94821 31.8323 2 34.0124 2 36.2857ZM26 10.5714C26 12.8447 25.0518 15.0249 23.364 16.6323C21.6761 18.2398 19.3869 19.1429 17 19.1429C14.6131 19.1429 12.3239 18.2398 10.636 16.6323C8.94821 15.0249 8 12.8447 8 10.5714C8 8.29814 8.94821 6.11797 10.636 4.51051C12.3239 2.90306 14.6131 2 17 2C19.3869 2 21.6761 2.90306 23.364 4.51051C25.0518 6.11797 26 8.29814 26 10.5714Z" stroke="#123456" stroke-width="3.8"/>
            </svg>
        </div>
    </button>

    <!-- 2fa Modal -->
    <div id="2faModal" x-show="open2fa" x-init="open2fa = document.getElementById('show2faModal') ? true : false" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button -->
            <button @click="open2fa = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                &times;
            </button>

            <h2 class="text-left text-xl font-bold mb-6">Authentification multifactorielle</h2>
            <svg class="m-auto" fill="#000000" width="200px" height="200px" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <style>
                    .cls-1 {
                      fill: none;
                    }
                  </style>
                </defs>
                <polygon points="11 23.18 9 21.179 7.589 22.589 11 26 17 20 15.59 18.59 11 23.18"/>
                <path d="M28,30H24V28h4V16H24V8a4.0045,4.0045,0,0,0-4-4V2a6.0067,6.0067,0,0,1,6,6v6h2a2.0021,2.0021,0,0,1,2,2V28A2.0021,2.0021,0,0,1,28,30Z" transform="translate(0 0)"/>
                <path d="M20,14H18V8A6,6,0,0,0,6,8v6H4a2,2,0,0,0-2,2V28a2,2,0,0,0,2,2H20a2,2,0,0,0,2-2V16A2,2,0,0,0,20,14ZM8,8a4,4,0,0,1,8,0v6H8ZM20,28H4V16H20Z" transform="translate(0 0)"/>
                <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"/>
            </svg>

            <form method="POST" action="{{ route('2fa.verify') }}">
                @csrf


                <div class="mb-4">
                    <x-input-label for="one_time_password" :value="__('Code Unique')" />
                    <x-text-input id="one_time_password" class="block mt-1 w-full" type="text" name="one_time_password" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('one_time_password')" class="mt-2" />
                </div>



                <!-- Submit Button -->
                <div class="text-center my-8">
                    <button class="w-64 mx-auto bg-[#444444] text-[#F4F0EC] py-2 rounded">
                        {{ __('Vérifier') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

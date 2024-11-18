<div
    x-data="{ open2fa: {{ $errors->any() || session('show_2fa_modal') ? 'true' : 'false' }} }"
>
    <!-- 2fa Modal -->
    <div id="2faModal" x-show="open2fa"  class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <!-- Close Button, logout -->
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-5xl p-2">
                    &times;
                </button>
            </form>
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
                    <x-text-input id="one_time_password" class="block mt-1 w-full" type="text" name="one_time_password" :value="old('code')" required autofocus autocomplete="code" />
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

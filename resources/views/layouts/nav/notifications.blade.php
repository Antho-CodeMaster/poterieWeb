<!-- Notification Dropdown -->

<div class="sm:flex sm:items-center ml-[15px]">
    <x-dropdown-notification align="right" width="64" class="dropdown-content-class">
        <x-slot name="trigger">
            <span class="relative group -translate-y-3">
                @if ($notificationCount > 0)
                    <p id="notificationCount"
                        class="mx-auto bg-red-500 text-white text-sm text-center rounded w-fit absolute z-0 -right-1 -top-5 {{ $notificationCount > 9 ? 'px-1' : 'px-1.5' }}">
                        {{ $notificationCount }}</p>
                @endif

                <button
                    class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div class="ms-1">
                        <svg width="34" height="34" viewBox="0 0 48 48" fill="none"
                            class="flex items-center" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M27.46 42C27.1084 42.6062 26.6037 43.1093 25.9965 43.4591C25.3892 43.8088 24.7008 43.9929 24 43.9929C23.2992 43.9929 22.6108 43.8088 22.0035 43.4591C21.3963 43.1093 20.8916 42.6062 20.54 42M36 16C36 12.8174 34.7357 9.76516 32.4853 7.51472C30.2348 5.26428 27.1826 4 24 4C20.8174 4 17.7652 5.26428 15.5147 7.51472C13.2643 9.76516 12 12.8174 12 16C12 30 6 34 6 34H42C42 34 36 30 36 16Z"
                                stroke="#444444" stroke-width="5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                    </div>
                </button>
                <!-- Tooltip content -->
                <div
                    class="absolute bg-hoverBeige text-md rounded-md p-2 shadow-lg w-fit
            invisible opacity-0 group-hover:visible group-hover:opacity-100 transition duration-200 ease-in-out
            translate-y-2 top-full left-1/2 transform -translate-x-1/2">
                    Notifications
                </div>
        </x-slot>

        </span>
        <x-slot name="content">
            <div class="bg-[#444444] text-[#f4f0ec] font-bold px-3 py-2 text-lg rounded-t-lg">
                Notifications
            </div>
            <div class="overflow-y-auto h-[400px] w-[300px] select-none p-4 space-y-2">
                @php
                    $visibleNotifications = Auth::user()
                        ->notifications->filter(function ($notification) {
                            return $notification->visible == 1;
                        })
                        ->sortByDesc('date');
                @endphp

                @if ($visibleNotifications->isNotEmpty())
                <p class="italic text-xs text-center">Faites glisser une notification vers la gauche pour plus d'options.</p>
                    @foreach ($visibleNotifications as $notification)
                        <div x-data="{ slid: false }" class="notification-item">
                            <div class="relative flex items-center p-4 bg-darkGrey rounded-lg overflow-hidden cursor-pointer"
                                @click="slid = !slid" :class="{ 'translate-x-[-50px]': slid }">
                                <!-- Notification Content -->
                                <div>
                                    <p class="notification-text flex-1 text-beige">
                                        {{ $notification->formatted_description }}</p>
                                    <p
                                        class="notification-text flex-1 text-right text-beige text-sm italic">
                                        {{ $notification->date }}</p>
                                </div>
                            </div>

                            <!-- Trash Icon -->
                            <div x-show="slid"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 transition-opacity duration-200 flex flex-col"
                                x-transition.opacity>
                                @if ($notification->lien != null)
                                    <button
                                        @click="slid = false; window.location.href='{{ $notification->lien }}'"
                                        class="focus:outline-none mb-6 text-[#59afff] hover:text-[#3779A9]">
                                        <svg class="w-6 h-6" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
                                        </svg>
                                    </button>
                                @endif
                                <button
                                    @click="slid = false; const notificationElement = $el.closest('.notification-item'); hideNotification({{ $notification->id_notification }}, notificationElement)"
                                    class="text-red-500 hover:text-red-700 focus:outline-none">
                                    <svg class="w-6 h-6" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-2 flex justify-center">
                        <span class="font-semibold text-darkGrey">Aucune notification à afficher</span>
                    </div>
                @endif
            </div>
        </x-slot>
    </x-dropdown-notification>
</div>

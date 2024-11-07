<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Modifier les informations de paiement') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Vos informations de paiement sont sensibles. Elles sont donc gardées en sécurité par Stripe, un logiciel tierce-partie. Vous serez donc redirigés vers leur site afin de définir vos informations.') }}
        </p>
        @if ($subbed)
            <p class="font-bold">Si vous changez votre méthode de paiement, les prochains paiements de votre abonnement
                seront faits en utilisant cette nouvelle méthode.</p>
        @endif
    </header>

    <form method="post" action="{{ route('profile.updateBlur') }}" class="mt-6 space-y-6" id="toggleForm">
        @csrf
        <h3 class="text-lg font-sm text-gray-900">Votre méthode de paiement par défaut</h3>
        @if ($card != null)
            <div class="border rounded-lg border-black w-fit pt-2 pb-2">
                <div class="w-full h-4 bg-black mb-6"></div>
                <p class="mx-4">
                    •••• •••• •••• {{ $card->last4 }}<br>
                    <span class="text-xs">Expiration: {{ $card->exp_month }}/{{ $card->exp_year }}</span>
                </p>
            </div>
        @else
            <p>Aucune méthode de paiement définie</p>
        @endif
        <div class="flex gap-4">
            <div x-data = "{link:'{{ route('profile.modifierCarte') }}'}">
                <x-button.green.pay type="button" @click="window.location.href=link">Modifier</x-button.green.pay>
            </div>
            @if ($card != null)
                <div x-data = "{link:'{{ route('profile.supprimerCarte') }}'}">
                    <x-button.red.x type="button" @click="window.location.href=link">Supprimer la
                        carte</x-button.red.x>
                </div>
            @endif
        </div>
    </form>
</section>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Abonnement Professionnel') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Vous êtes abonné à Artterre afin d\'avoir un kiosque et de vendre vos articles. Vous pouvez annuler votre abonnement. Vous conserverez vos accès
                                                                                            jusqu\'à la prochaine date où votre facturation aurait été prévue.') }}
        </p>
    </header>

    <div>
        <p>Date de l'abonnement: {{ $subscription['debut'] }}</p>
        <p>Date du dernier renouvellement: {{ $subscription['debut_periode'] }}</p>
        @if (!$subscription['cancel_at_period_end'])
            <p>Votre prochain paiement est prévu <span class="font-bold">{{ $subscription['fin_periode'] }}</span>.</p>
        @endif

    </div>
    @if ($subscription['cancel_at_period_end'])
        <div>
            <p>Vous avez annulé cet abonnement.</p>
            <p>Votre kiosque demeure disponible jusqu'à <span
                    class="font-bold">{{ $subscription['fin_periode'] }}</span>.</p>
        </div>
    @else
        <x-button.red.x class="shadow-inner" x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-sub-deletion')">{{ __('Annuler l\'abonnement') }}</x-button.red.x>
    @endif
    <x-modal name="confirm-sub-deletion" :show="$errors->subDeletion->isNotEmpty()" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous certain de vouloir annuler votre abonnement?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Une fois votre abonnement annulé, vous conserverez vos accès jusqu'à <span class="font-bold">{{$subscription['fin_periode']}}</span>. Puis, vous n'aurez plus accès à votre kiosque et il sera impossible d'accès pour les clients. Si vous vous réabonnez, vous retrouverez votre kiosque et vos articles.
            </p>

            <div class="mt-6 flex gap-4 justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Retour') }}
                </x-secondary-button>
                <div x-data = "{link:'{{ route('annuler-abonnement') }}'}">
                    <x-button.red.empty type="button" @click="window.location.href=link">Annuler
                        l'abonnement</x-button.red.empty>
                </div>
            </div>
        </div>
    </x-modal>
</section>

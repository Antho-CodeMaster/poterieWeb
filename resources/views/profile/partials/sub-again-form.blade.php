<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Abonnement Professionnel') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Nos informations indiquent que vous vous êtes abonné à Terracium par le passé afin d\'avoir un kiosque et de vendre vos articles. Vous pouvez vous réabonner à tout moment. Vous retrouverez vos accès, votre kiosque et vos articles.') }}
        </p>
    </header>

    <div>
        <p>Date de l'abonnement: {{ $subscription['debut'] }}</p>
        <p>Date du dernier renouvellement effectué: {{ $subscription['debut_periode'] }}</p>
        <p>Date à laquelle vos accès ont été révoqués: {{ $subscription['fin_periode'] }}</p>
    </div>
    <div x-data = "{link:'{{ route('abonnement') }}'}">
        <x-button.green.pay type="button" @click="window.location.href=link">Vous réabonner</x-button.green.pay>
    </div>
</section>


<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Modifier les informations de paiement') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('
            Vos informations de paiement sont sensibles. Elles sont donc gardées en sécurité par Stripe, un logiciel tierce-partie. Vous serez donc redirigés vers leur site afin de définir vos informations.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateBlur') }}" class="mt-6 space-y-6" id="toggleForm">
        @csrf

        <div x-data = "{link:'{{route('stripe.facturation')}}'}">
            <x-button.green.pay type="button" @click="window.location.href=link">Modifier</x-button.green.pay>
        </div>
    </form>
</section>

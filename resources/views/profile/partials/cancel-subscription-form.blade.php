<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Annuler l\'abonnement') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Vous êtes abonné à Terracium afin d\'avoir un kiosque et de vendre vos articles. Vous pouvez annuler votre abonnement. Vous conserverez vos accès
                    jusqu\'à la prochaine date où votre facturation aurait été prévue.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateBlur') }}" class="mt-6 space-y-6" id="toggleForm">
        @csrf

        <div x-data = "{link:'{{route('annuler-abonnement')}}'}">
            <x-button.red.x type="button" @click="window.location.href=link">Annuler l'abonnement</x-button.red.x>
        </div>
    </form>
</section>


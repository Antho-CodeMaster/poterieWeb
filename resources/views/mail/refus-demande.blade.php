<x-mail::message>
# Demande pour devenir artiste-vendeur chez {{ config('app.name') }}

Après avoir jeté un oeil à votre demande pour devenir vendeur chez {{ config('app.name') }}, nous avons le regret de vous informer que votre demande a été refusée par l'équipe d'administration.

**Raison:**
{{ $reason }}

<x-mail::button :url="route('devenir-artiste')">
Effectuer une nouvelle demande
</x-mail::button>

Merci encore d'avoir appliqué,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>

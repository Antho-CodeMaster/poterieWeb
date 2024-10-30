<x-mail::message>
# Renouvellement refusé chez {{ config('app.name') }}

Après avoir jeté un oeil à votre demande pour renouveler votre compte étudiant chez {{ config('app.name') }}, nous avons le regret de vous informer que votre demande a été refusée par l'équipe d'administration.

**Raison:**
{{ $reason }}

Vous n'avez donc plus accès à votre compte. Si, toutefois, une nouvelle demande est effectuée et qu'elle est acceptée, votre profil sera réactivé.

<x-mail::button :url="route('devenir-artiste')">
Effectuer une nouvelle demande
</x-mail::button>

Merci encore d'avoir appliqué,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>

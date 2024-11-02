<x-mail::message>
# Demande pour devenir artiste-vendeur chez {{ config('app.name') }}

Après avoir jeté un oeil à votre demande pour devenir vendeur chez {{ config('app.name') }}, nous avons accepté de vous créer un kiosque!

Pour accéder à votre nouveau kiosque, tel que mentionné dans le formulaire pour devenir artiste, vous devez payer votre abonnement.

<x-mail::button :url="route('abonnement')">
Payer mon abonnement
</x-mail::button>

Merci encore d'avoir appliqué et bienvenue dans l'équipe,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>

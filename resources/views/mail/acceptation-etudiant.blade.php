<x-mail::message>
# Demande pour devenir artiste-vendeur chez {{ config('app.name') }}

Après avoir jeté un oeil à votre demande pour devenir vendeur chez {{ config('app.name') }}, nous avons accepté de vous créer un kiosque!

<x-mail::button :url="route('kiosque', ['idUser' => $id]).'?firstaccess=true'">
Accéder à mon nouveau kiosque
</x-mail::button>

Merci encore d'avoir appliqué et bienvenue dans l'équipe,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>

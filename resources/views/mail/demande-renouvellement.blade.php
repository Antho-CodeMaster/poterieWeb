<x-mail::message>
# Renouvellement de votre compte gratuit chez {{ config('app.name') }}

Puisque votre abonnement est gratuit et pour valider que vous êtes toujours étudiant, les administrateurs requièrent que vous revalidiez votre abonnement chez {{ config('app.name') }}.<br><br>
Ainsi, vous avez jusqu'à **{{ $date }}** pour effectuer votre demande, sans quoi vous perdrez vos accès.

<x-mail::button :url="route('renouvellement-artiste')">
    Effectuer votre renouvellement
</x-mail::button>

Veuillez noter que si votre demande n'a pas de verdict d'ici à ce que le mois soit écoulé, vos accès seront conservés tant que vous ayiez effectué une demande.

Merci encore de supporter le projet!<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>

<x-app-layout>
    <div>
        <h1 class="titre1-dark my-6 text-center">Merci pour votre achat!</h1>
        <div class="m-auto w-[50%]">
            Nous vous remercions chaleureusement pour votre soutien à notre communauté de céramistes, composée
            d'étudiants et de professionnels passionnés. Chaque pièce que vous achetez contribue à encourager la
            créativité et l’artisanat unique de nos membres.
            <br><br>
            Pour consulter votre facture, <a href="{{ $facture }}" class="underline text-[#73BCFF]"
                target="_blank">cliquez ici pour la télécharger.</a> Sachez également que toutes vos factures restent
            accessibles dans votre profil, sous la section "historique de factures" et qu'une copie vous est envoyé par
            courriel.
            <br><br>
            Votre commande sera livré au
            {{ $commande->no_civique . ', ' . $commande->rue . ', ' . $commande->ville->ville . ', ' . $commande->code_postal }} tel
            qu'indiqué lors du paiement. Votre commande sera traité par les artistes concernés dans un délais de 14
            Jours. Il est à noter que chaque artiste est responsable de la livraison de ses articles. Donc si plusieurs
            items de votre commande proviennent d'artistes différents, vos articles n'arriverons pas tous à la même
            date.
            <br><br>
            N’hésitez pas à revenir découvrir de nouvelles créations ! Merci encore pour votre confiance et votre
            engagement envers notre communauté.
        </div>
        <div class="flex justify-around m-auto w-[50%] my-8">
            <form action="/">
                <x-button.green.empty>
                    Revenir au magasin
                </x-button.green.empty>
            </form>
            <form action="{{ route('commandes') }}">
                <x-button.blue.empty>
                    Visualiser mes commandes
                </x-button.blue.empty>
            </form>

        </div>
    </div>
</x-app-layout>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de vente</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { width: 80%; margin: auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .info, .summary { margin-bottom: 20px; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary table, .summary th, .summary td { border: 1px solid #ddd; padding: 8px; }
        .footer { text-align: center; font-size: 12px; margin-top: 20px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Artterre</h1>
            <p>Reçu de vente pour artiste</p>
            <p><strong>Date de la facture</strong> {{ $date }}</p>
        </div>

        <div class="info">
            <p><strong>Artiste:</strong> {{ $nom_artiste }}</p>
            <p><strong>ID artiste: </strong> {{ $id_artiste }}</p>
        </div>

        <div class="summary">
            <h3>Résumé de la facture</h3>
            <p><strong>Date de transaction:</strong> {{ $transaction_date }}</p>
            <p><strong>ID de la commande:</strong> {{ $id_commande }}</p>
            <p><strong>ID de session Stripe:</strong> {{ $stripe_session_id }}</p>

            <h3>Articles vendu</h3>
            <table>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->article->nom }}</td>
                        <td>{{ $transaction->quantite }}</td>
                        <td>{{number_format($transaction->prix_unitaire ,2,'.',' ')}}$</td>
                        <td>{{ number_format($transaction->prix_unitaire *  $transaction->quantite,2,'.',' ')}}$</td>
                    </tr>
                @endforeach

                <!-- End loop -->
                <tr>
                    <td>Aide à la livraison</td>
                    <td></td>
                    <td></td>
                    <td>{{number_format($livraison,2,'.',' ') }}$</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Merci d'utiliser notre plateforme!</p>
            <p>Pour toute question, contactez nous à leofiliatreault.business@gmail.com</p>
        </div>
    </div>
</body>
</html>

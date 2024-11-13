<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
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
            <h1>@Terracium</h1>
            <p>Facture de vente pour artiste</p>
            <p><strong>Date de la facture</strong> {{ $date }}</p>
        </div>

        <div class="info">
            <p><strong>Artiste:</strong> {{ $nom_artiste }}</p>
            <p><strong>ID Artiste: </strong> {{ $id_artiste }}</p>
        </div>

        <div class="summary">
            <h3>Résumé de la facture</h3>
            <p><strong>Date de transaction:</strong> {{ $transaction_date }}</p>
            <p><strong>ID de la commande:</strong> {{ $id_commande }}</p>
            <p><strong>ID Session Stripe:</strong> {{ $stripe_session_id }}</p>

            <h3>Articles vendu</h3>
            <table>
                <tr>
                    <th>Nom article</th>
                    <th>Quantite</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->article->nom }}</td>
                        <td>{{ $transaction->quantite }}</td>
                        <td>{{ $transaction->prix_unitaire }}</td>
                        <td>{{ $transaction->prix_unitaire *  $transaction->quantite}}</td>
                    </tr>
                @endforeach

                <!-- End loop -->
            </table>
        </div>

        <div class="footer">
            <p>Merci d'utiliser notre plateforme</p>
            <p>Contactez nous a support@terracium.com</p>
        </div>
    </div>
</body>
</html>

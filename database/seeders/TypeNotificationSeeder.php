<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeNotificationSeeder extends Seeder
{
    /**
     * Ces enregistrements devront être conservés en tout temps dans la base de données.
     */
    public function run(): void
    {
        DB::table('types_notification')->insert([
            'description' => 'ATTENTION: un administrateur vous a averti pour la raison suivante: [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre demande pour devenir vendeur a été refusée. Raison: [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre demande pour devenir vendeur a été acceptée! Vous avez maintenant accès à votre kiosque dans la barre de navigation.',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'ATTENTION: À partir d\'aujourd\'hui, vous avez un mois pour renouveler votre statut d\'étudiant. Un courriel vous a été envoyé avec plus d\'informations.',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre demande pour devenir vendeur a été acceptée! Vous devez payer votre abonnement pour accéder au site.',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Vous avez une nouvelle commande en cours, [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre abonnement est terminé! Vous pouvez le réactiver via Paramètres > Facturation.',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Vous n\'avez pas fait votre renouvellement à temps. Vos accès artiste ont donc été retirés. Vous pouvez les récupérer en cliquant sur l\'icône dans la barre de navigation.',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Un de vos articles a été supprimé par l\'administration. Nom de l\'article: [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Votre demande concernant un article non reçu a été supprimée par l\'administration. Vous devriez avoir reçu un courriel avec plus de renseignements. Si ce n\'est pas le cas, veuillez nous contacter via le lien en bas de page.',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Un de vos articles a été remis en ligne par l\'administration. Nom de l\'article: [1]',
        ]);

        DB::table('types_notification')->insert([
            'description' => 'Bienvenue chez Artterre! Pour plus de sécurité, veuillez configurer votre question de sécurité et l\'authentification à deux facteurs et via les paramètres.',
        ]);
    }
}

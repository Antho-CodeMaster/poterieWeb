<?php

namespace App\Models;

use EasyPost\EasyPostClient;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WeakMap;

class EasyPost extends Model
{
    #===========================================#
    #        PARAMÈTRES ET CONSTRUCTEUR         #
    #===========================================#

    private $client;
    private $secret;
    private $hookId;

    public function __construct()
    {
        $this->client = new EasyPostClient(env('EASYPOST_API_KEY')); // Utilisation d'un fichier .env pour stocker la clé
        $this->secret = env('EASYPOST_WEBHOOK_SECRET');
    }

    #===========================================#
    #                  TRACKER                  #
    #===========================================#

    // Création d'un tracker et retourne l'objet tracker
    public function createTracker($deliveryCode, $carrier)
    {
        # Éviter d'appeler la fonction si les paramètre sont vide
        if (empty($deliveryCode)) {
            Log::error('Le code de livraison est manquante pour la création du tracker.');
            return null;
        }

        if (empty($carrier)) {
            Log::error('La compagnie de livraison est manquante pour la création du tracker.');
            return null;
        }

        try {
            $tracker = $this->client->tracker->create([ # Création du tracker
                'tracking_code' => $deliveryCode,
                'carrier' => $carrier
            ]);
            return $tracker;
        } catch (Exception $e) {
            Log::error('Erreur lors de la création du tracker avec le numéro de suivie (' . $deliveryCode . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupération du tracker à l'aide de son Id de tracker
    private function getTracker($trackingId)
    {
        try {
            $tracker = $this->client->tracker->retrieve($trackingId);
            return $tracker;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération du tracker (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupération du statut à l'aide de son Id de tracker
    public function getStatus($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            return $tracker ? $tracker->status : null;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération du statut (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupération des détails de tracking à l'aide de son Id de tracker et retourne le tout en format JSON
    public function getTrackingDetails($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            return $tracker ? $tracker->tracking_details : null;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des details du tracking (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupération de la date estimée de livraison à l'aide de son Id de tracker
    public function getEstimatedDelivery($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            # Si Tracker recu refomate le pour l'insérer dans la BD du site
            return $tracker ? Carbon::parse($tracker->est_delivery_date)->format('Y-m-d') : null;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération du estimated delivery du tracker (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupération du transporteur(compagnie de livraison) de la livraison à l'aide de son Id de tracker
    public function getCarrier($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            return $tracker ? $tracker->carrier : null;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération du transporteur du tracker (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupération de la destination à l'aide de son Id de tracker
    public function getDestination($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            return $tracker ? $tracker->destination_location : null;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération de la destination finale du tracker (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Récupère la date de réception effective à l'aide de son Id de tracker
    public function getDeliveryDate($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            # Parcourir les détails du suivi pour trouver quand elle a été livré
            foreach ($tracker->tracking_details as $detail) {
                if ($detail->status === 'delivered') {
                    # Formater la date avec Carbon
                    return Carbon::parse($detail->datetime)->format('Y-m-d');
                }
            }
            # Si aucun statut "delivered" n'a été trouvé
            return 'Not delivered yet';
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération de la date de réception du tracker (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }


    // Récupération de la destination à l'aide de son Id de tracker
    public function getTrackerURL($trackingId)
    {
        try {
            $tracker = $this->getTracker($trackingId);
            return $tracker ? $tracker->public_url : null;
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération du public URL du tracker (' . $trackingId . ') :' . $e->getMessage());
            return null;
        }
    }

    #===========================================#
    #                  WEBHOOK                  #
    #===========================================#

    // Crée un WebHook et retourne l'objet WebHook
    public function createWebHook($url, $secret)
    {
        try {
            $webhook = $this->client->webhook->create([ # Créer un WebHook avec l'api du client. (Tracker API)
                'url' => $url,
                'webhook_secret' => $secret,
            ]);

            $this->hookId = $webhook->id; # Récupère le id de ce WebHook associé au suivi des evenements des trackers
            return $webhook;
        } catch (Exception $e) {
            Log::error('Erreur lors de la création du webhook : ' . $e->getMessage());
            return null;
        }
    }

    // Récupère tous les WebHook et les renvoie sous format JSON
    public function getAllWebHook()
    {
        try {
            $webhooks = $this->client->webhook->all();

            return $webhooks;
        } catch (Exception $e) {
            Log::error('Erreur lors du get des webhooks : ' . $e->getMessage());
            return null;
        }
    }

    // Récupère le WebHook et le renvoie sous format JSON
    public function getWebHook()
    {
        try {
            $webhook = $this->client->webhook->retrieve($this->hookId);

            return $webhook;
        } catch (Exception $e) {
            Log::error('Erreur lors du get du webhook(' . $this->hookId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Update le WebHook et le renvoie sous format JSON
    public function updateWebHook()
    {
        try {
            $webhook = $this->client->webhook->update($this->hookId);

            return $webhook;
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'update du webhook(' . $this->hookId . ') :' . $e->getMessage());
            return null;
        }
    }

    // Supprime un WebHook avec son Id
    public function deleteWebHook()
    {
        try {
            $this->client->webhook->delete($this->hookId); # Supprime le webhook
            return ['success' => true, 'message' => 'Webhook supprimé']; # Retourne un message de succès
        } catch (Exception $e) {
            Log::error('Erreur lors du delete du webhook(' . $this->hookId . ') :' . $e->getMessage());
            return null;
        }
    }

    #===========================================#
    #                  EVENTS                   #
    #===========================================#

    // Récupère un Event de tracker avec son Id de tracking et le renvoie sous format JSON
    public function getTrackerEvent(Request $request)
    {
        # Validation de la clé secrète du webhook pour s'assurer que la requête vient de EasyPost
        if ($request->header('X-EasyPost-Webhook-Signature') !== $this->secret) {
            return "Invalid signature";
        }

        # Récupération des données envoyées par EasyPost
        $events = $request->input('events');  # L'événement reçu de EasyPost

        if (str_contains($events['description'], 'updated')) # Vérifie que l'évenement ne concerne que les update de tracker
        {
            $trackingId = $events['id'];  # L'ID du tracker mis à jour
            return $trackingId;
        }

        // Si aucun événement n'est lié à un tracker mis à jour, retourner une erreur
        return "No events";
    }
}

<?php

namespace App\Models;

use EasyPost\EasyPostClient;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WeakMap;

class EasyPost extends Model
{
    #===========================================#
    #        PARAMÈTRES ET CONSTRUCTEUR         #
    #===========================================#

    private $client;

    private $webhookURL;
    private $secret;

    private $hookId;

    public function __construct()
    {
        $this->client = new EasyPostClient(env('EASYPOST_API_KEY')); # Utilisation d'un fichier .env pour stocker la clé

        $this->webhookURL = "http://artterreceramique.ca/easypost/events";
        $this->secret = env('EASYPOST_WEBHOOK_SECRET'); # Initialisation du secret à partir du fichier .env

        // Recherche les webhooks existants pour l'URL donnée
        $webhooks = $this->client->webhook->all(); // Récupère tous les webhooks
        $existingWebhook = collect($webhooks->webhooks)->firstWhere('url', $this->webhookURL);

        if ($existingWebhook) {
            // Si un webhook existe déjà, récupère son ID
            $this->hookId = $existingWebhook->id;
        } else {
            // Sinon, crée un nouveau webhook
            $newWebhook = $this->createWebHook($this->webhookURL, $this->secret);
            $this->hookId = $newWebhook->id;
        }
    }

    #===========================================#
    #                  TRACKER                  #
    #===========================================#

    // Création d'un tracker et retourne l'objet tracker
    public function createTracker($deliveryCode, $carrier)
    {
        // Vérifications des paramètres
        if (empty($deliveryCode)) {
            throw new Exception('Code de livraison manquant');
        }

        if (empty($carrier)) {
            throw new Exception('Compagnie de livraison manquante');
        }

        // Création du tracker
        $tracker = $this->client->tracker->create([
            'tracking_code' => $deliveryCode,
            'carrier' => $carrier
        ]);

        // Vérification de la création du tracker
        if (!$tracker) {
            throw new Exception('Erreur lors de la création du tracker');
        }

        // Vérification du contenu du tracker
        if (empty($tracker) || empty($tracker->id) || $tracker->tracking_code !== $deliveryCode) {
            throw new Exception('Tracker attaché à aucune livraison ayant le code de suivie : ' . $deliveryCode);
        }

        return $tracker;
    }


    // Récupération du tracker à l'aide de son Id de tracker
    private function getTracker($trackingId)
    {
        if (empty($trackingId)) {
            throw new Exception('Code de tracking manquant');
        }

        $tracker = $this->client->tracker->retrieve($trackingId);

        // Vérifier si le tracker a été récupéré correctement
        if (!$tracker) {
            // Si aucun tracker n'a été récupéré, on lance une exception avec un message clair
            throw new Exception('Erreur lors de la récupération du tracker avec l\'ID : ' . $trackingId);
        }

        return $tracker;
    }


    // Récupération du statut à l'aide de son Id de tracker
    public function getStatus($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        return $tracker->status;
    }

    // Récupération des détails de tracking à l'aide de son Id de tracker et retourne le tout en format JSON
    public function getTrackingDetails($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        return $tracker->tracking_details;
    }

    // Récupération de la date estimée de livraison à l'aide de son Id de tracker
    public function getEstimatedDelivery($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        return Carbon::parse($tracker->est_delivery_date)->format('Y-m-d');
    }

    // Récupération du transporteur(compagnie de livraison) de la livraison à l'aide de son Id de tracker
    public function getCarrier($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        return $tracker->carrier;
    }

    // Récupération de la destination à l'aide de son Id de tracker
    public function getDestination($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        return $tracker->destination_location;
    }

    // Récupère la date de réception effective à l'aide de son Id de tracker
    public function getDeliveryDate($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        // Parcourir les détails du suivi pour trouver quand elle a été livré
        foreach ($tracker->tracking_details as $detail) {
            if ($detail->status === 'delivered') {
                // Formater la date avec Carbon
                return Carbon::parse($detail->datetime)->format('Y-m-d');
            }
        }

        // Si aucun statut "delivered" n'a été trouvé
        return 'Pas encore livré';
    }


    // Récupération du public URL du tracker
    public function getTrackerURL($trackingId)
    {
        $tracker = $this->getTracker($trackingId);

        return $tracker->public_url;
    }

    #===========================================#
    #                  WEBHOOK                  #
    #===========================================#

    // Crée un WebHook et retourne l'objet WebHook
    public function createWebHook($url, $secret)
    {
        # Création du WebHook via l'API du client
        $webhook = $this->client->webhook->create([
            'url' => $url,
            'webhook_secret' => $secret,
        ]);

        # Vérification si le Webhook a bien été créé
        if (!$webhook) {
            throw new Exception('Erreur lors de la création du webhook avec l\'URL : ' . $url);
        }

        $this->hookId = $webhook->id;  # Récupère l'ID du WebHook associé au suivi des événements des trackers
        return $webhook;
    }

    // Récupère tous les Webhooks et les renvoie sous format JSON
    public function getAllWebHook()
    {
        # Récupérer tous les WebHooks via l'API du client
        $webhooks = $this->client->webhook->all();

        # Vérification si les webhooks sont récupérés correctement
        if (!$webhooks) {
            throw new Exception("Erreur lors de la récupération des webhooks.");
        }

        return $webhooks;
    }


    // Récupère le WebHook et le renvoie sous format JSON
    public function getWebHook()
    {
        # Récupérer le WebHook via l'API du client en utilisant l'ID du hook
        $webhook = $this->client->webhook->retrieve($this->hookId);

        # Vérification si le WebHook est récupéré correctement
        if (!$webhook) {
            throw new Exception('Erreur lors de la récupération du webhook avec l\'ID : ' . $this->hookId);
        }

        return $webhook;
    }


    // Update le WebHook et le renvoie sous format JSON
    public function updateWebHook()
    {
        # Tenter de mettre à jour le WebHook avec l'ID
        $webhook = $this->client->webhook->update($this->hookId);

        # Vérifier si la mise à jour a échoué
        if (!$webhook) {
            throw new Exception('Erreur lors de la mise à jour du webhook avec l\'ID : ' . $this->hookId);
        }

        return $webhook;
    }


    // Supprime un WebHook avec son Id
    public function deleteWebHook()
    {
        # Tenter de supprimer le WebHook avec l'ID
        $result = $this->client->webhook->delete($this->hookId);

        # Vérifier si la suppression a échoué
        if (!$result) {
            throw new Exception('Erreur lors de la suppression du webhook avec l\'ID : ' . $this->hookId);
        }

        return ['success' => true, 'message' => 'Webhook supprimé']; // Retourner un message de succès
    }


    #===========================================#
    #                  EVENTS                   #
    #===========================================#

    // Récupère tous les évenements relié à un Webhook
    public function getAllEvents()
    {
        $events = $this->client->event->all([
            'page_size' => 5
        ]);

        if (empty($events) || !isset($events['events']) || count($events['events']) === 0) { # Si aucun évenement n'est retourné
            throw new Exception('Aucun event n\'est associé à cette ID');
        }

        return $events;
    }

    // Récupère un événement particulier grâce à son ID
    public function getEventByID($evtID)
    {
        // Vérifie que l'ID est valide
        if (empty($evtID)) {
            throw new Exception('L\'ID de l\'événement est manquant ou invalide.');
        }

        $event = $this->client->event->retrieve($evtID);

        // Vérifie si l'événement existe
        if (empty($event) || !isset($event->id)) {
            throw new Exception('Aucun événement n\'est associé à cet ID.');
        }

        return $event;
    }

    // Function qui gère tout
    public function getTrackerFromEvent(Request $request)
    {
        # Vérifier la signature du webhook pour valider que la requête vient bien de EasyPost
        if ($request->header('X-EasyPost-Webhook-Signature') !== $this->secret) {
            throw new Exception('La requête ne semble pas venir de EasyPost');
        }

        # Récupération des événements envoyés par EasyPost
        $event = json_decode($request->getContent(), true);
        if (!is_array($event)) {
            throw new Exception('Le contenu de la requête est invalide ou mal formé.');
        }

        # Si l'évenement ne contient pas de description ou que la desciption n'est pas de type "updated"
        if (!isset($event['description']) || !str_contains($event['description'], 'updated')) {
            throw new Exception('Aucun événement de mise à jour de tracker trouvé.');
        }

        # Si l'évenement ne contient pas de id dans son result throw une erreur
        if (!isset($event['result']['id']) || empty($event['result']['id'])) {
            throw new Exception('L\'événement ne contient pas d\'ID de tracker.');
        }

        return $event['result']['id']; # Retourne le id tracker
    }
}

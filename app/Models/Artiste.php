<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Artiste extends Model
{
    use HasFactory;
    protected $table = "artistes";
    protected $primaryKey = "id_artiste";
    protected $fillable = [
        'id_user',
        'id_theme',
        'nom_artiste',
        'path_photo_profil',
        'is_etudiant',
        'actif',
        'description',
        'couleur_banniere'
    ];

    public function reseaux()
    {
        return $this->belongsToMany(Reseau::class, "reseaux_artistes", 'id_artiste', 'id_reseau')->withPivot('username');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'id_artiste', 'id_artiste');
    }

    public function subscribed(): bool
    {
        $usr = User::where("id", $this->id_user)->first();
        if ($usr->stripe_id != null) {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $subscriptions = \Stripe\Subscription::all([
                'customer' => $usr->stripe_id,
                'status' => 'active',
            ]);

            foreach ($subscriptions->data as $subscription)
                foreach ($subscription->items->data as $item)
                    if ($item->price->product === env("SUBSCRIPTION_PRODUCT_ID"))
                        return true;
        }
        return false;
    }

    public function validate()
    {
        if ($this->actif == 1) {
            // Validation de l'artiste pour terminer un abonnement
            if ($this->is_etudiant == false && !$this->subscribed()) {
                $this->actif = 0;
                $this->save();

                // Notifier in-app pour avertir l'artiste qu'il perd ses accès
                $notif = Notification::create([
                    'id_type' => 6,
                    'id_user' => $this->id_user,
                    'date' => now(),
                    'message' => '',
                    'lien' => route('profile.facturation'),
                    'visible' => 1
                ]);
                $notif->save();
            }
        }

        if ($this->is_etudiant == true) {
            $date = Carbon::create(Renouvellement::latest()->first()->created_at);

            // S'assurer que le checkup soit seulement fait si l'étudiant était déjà existant au moment du renouvellement
            if ($this->created_at < $date) {
                // Retrouver la dernière demande de renouvellement de l'utilisateur
                $demande = Demande::where('id_user', $this->id_user)->where('id_type', 1)->latest('date')->first();

                // Si la date du dernier renouvellement est passée
                if (now() > $date->addMonth()) {
                    // Si aucune demande de renouvellement n'a été faite depuis, on doit rendre l'artiste inactif.
                    if ($demande == null || $demande->date < $date) {
                        $this->actif = 0;
                        $this->save();

                        // Notifier in-app pour avertir l'artiste qu'il perd ses accès
                        $notif = Notification::create([
                            'id_type' => 7,
                            'id_user' => $this->id_user,
                            'date' => now(),
                            'message' => '',
                            'lien' => route('renouvellement-artiste'),
                            'visible' => 1
                        ]);
                        $notif->save();

                        // Les autres cas de figure sont gérés dans les méthode accept() et deny() de DemandeController.
                    }
                }
            }
        }
    }
}

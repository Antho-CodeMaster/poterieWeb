<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey ='id_transaction';
    public $timestamps = false;

    protected $fillable = [
        'id_commande',
        'id_article',
        'quantite',
        'prix_unitaire',
        'trackingId_easypost',         // Pour le tracker EasyPost
        'code_ref_livraison',           // Le code de référence de la livraison
        'id_compagnie',                 // L'ID de la compagnie de livraison
        'date_reception_prevue',        // La date de réception prévue
        'date_reception_effective',
        'id_etat',
    ];


    public function article_non_recu(){
        return $this->hasMany(Article_non_recu::class,'id_transaction','id_transaction');
    }
    public function etat_transaction(){
        return $this->belongsTo(Etat_transaction::class, 'id_etat', 'id_etat');
    }
    public function article(){
        return $this->belongsTo(Article::class, 'id_article', 'id_article');
    }
    public function compagnie_livraison(){
        return $this->belongsTo(Compagnie_livraison::class, 'id_compagnie', 'id_compagnie');
    }
    public function photo_livraison(){
        return $this->hasMany(Photo_livraison::class,'id_transaction', 'id_transaction');
    }
    public function commande(){
        return $this->belongsTo(Commande::class, 'id_commande', 'id_commande');
    }
}

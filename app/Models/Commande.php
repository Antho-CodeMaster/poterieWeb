<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $table = 'commandes';
    protected $primaryKey = 'id_commande';
    protected $fillable = ['is_panier', 'id_user', 'date', 'no_civique', 'rue','code_postal', 'id_ville', 'payment_intent_id'];

    public function transactions(){
        return $this->hasMany(Transaction::class, 'id_commande','id_commande')->orderByDesc('id_etat');
    }
    public function user(){
        return $this->belongsTo(User::class,'id','id_user');
    }
    public function ville(){
        return $this->belongsTo(Ville::class,'id_ville', 'id_ville');
    }
}

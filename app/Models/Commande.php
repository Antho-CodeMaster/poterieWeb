<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $table = 'commandes';
    protected $primaryKey = 'id_commande';

    public function transactions(){
        return $this->hasMany(Transaction::class, 'id_commande','id_commande');
    }
    public function user(){
        return $this->belongsTo(User::class,'id_user','id_user');
    }
    public function ville(){
        return $this->belongsTo(Ville::class,'id_ville', 'id_ville');
    }
}

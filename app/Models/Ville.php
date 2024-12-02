<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $table = 'villes';
    protected $primaryKey = 'id_ville';
    protected $fillable = ['id_ville', 'ville'];
    public $timestamps = false;

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_ville', 'id_ville');
    }

}

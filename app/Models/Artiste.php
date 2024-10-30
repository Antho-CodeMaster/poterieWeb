<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function reseaux() {
        return $this->belongsToMany(Reseau::class, "reseaux_artistes", 'id_artiste', 'id_reseau')->withPivot('username');
    }
    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'id_user' , 'id');
    }

    public function articles() {
        return $this->hasMany(Article::class, 'id_artiste', 'id_artiste');
    }
}


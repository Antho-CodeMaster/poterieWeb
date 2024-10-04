<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = "articles";
    protected $primaryKey = "id_article";
    protected $fillable = [
        'id_artiste',
        'id_etat',
        'nom',
        'description',
        'prix',
        'hauteur',
        'largeur',
        'profondeur',
        'poids',
        'quantite_disponible',
        'date_publication',
        'is_en_vedette',
        'is_sensible',
        'is_alimentaire',
        'is_unique',
        'couleur',
    ];

    public function etat()
    {
        return $this->belongsTo(Etat_article::class, "id_etat", "id_etat");
    }

    public function photosArticle()
    {
        return $this->belongsTo(Photo_article::class, "id_article", "id_article");
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_article', 'id_article');
    }

    public function isLikedByUser($id_user)
    {
        return $this->likes()->where('id_user', $id_user)->exists();
    }

    public function artiste()
    {
        return $this->hasOne(Artiste::class, 'id_artiste');
    }
}

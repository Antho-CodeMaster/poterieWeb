<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function motCles()
    {
        return $this->belongsToMany(Mot_cle::class, 'mots_cles_articles', 'id_article', 'id_mot_cle');
    }

    public function getArtiste()
    {
        return $this->belongsTo(Artiste::class, 'id_artiste', 'id_artiste');
    }

    public function artiste()
    {
        return $this->belongsTo(Artiste::class,'id_artiste','id_artiste');
    }

    public function photo_article(){
        return $this->hasMany(Photo_article::class,'id_article','id_article');
    }

    public function collection(){
        return $this->belongsToMany(Collection::class, 'article_collection', 'id_article', 'id_collection');
    }

    public function mot_cle(){
        return $this->belongsToMany(Mot_cle::class,'mot_cle_article','id_article', 'id_mot_cle');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collections_articles', 'id_article', 'id_collection');
    }

    public function cmApo($units){
        return $units / 2.54;
    }
}

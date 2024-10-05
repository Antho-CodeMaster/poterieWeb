<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $primaryKey = 'id_article';


    public function artiste(){
        return $this->belongsTo(Artiste::class,'id_artiste','id_artiste');
    }
    public function photo_article(){
        return $this->hasMany(Photo_article::class,'id_article','id_article');
    }
    public function etat(){
        return $this->belongsTo(Etat_article::class, 'id_etat');
    }
    public function collection(){
        return $this->belongsToMany(Collection::class, 'article_collection', 'id_article', 'id_collection');
    }
    public function mot_cle(){
        return $this->belongsToMany(Mot_cle::class,'mot_cle_article','id_article', 'id_mot_cle');
    }
    public function like(){
        return $this->belongsToMany(User::class,'like', 'id_article','id_user');
    }
}

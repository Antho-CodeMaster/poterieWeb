<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = "articles";
    protected $primaryKey = "id_article";

    public function etat(){
        return $this->belongsTo(Etat_article::class, "id_etat", "id_etat");
    }

    public function photosArticle(){
        return $this->belongsTo(Photo_article::class, "id_article", "id_article");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mot_cle_article extends Model
{
    use HasFactory;
    protected $table = "mots_cles_articles";
    protected $fillable = [
        'id_mot_cle',
        'id_article',
    ];
    protected $table = "mots_cles_articles";

    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article', 'id_article');
    }

    public function motCle()
    {
        return $this->belongsTo(Mot_cle::class, 'id_mot_cle', 'id_mot_cle');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mot_cle extends Model
{
    use HasFactory;
    protected $table = "mots_cles";
    protected $primaryKey = "id_mot_cle";
    protected $fillable = ['mot_cle'];
    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'mots_cles_articles', 'id_mot_cle', 'id_article');
    }
}

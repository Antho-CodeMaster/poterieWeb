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
}

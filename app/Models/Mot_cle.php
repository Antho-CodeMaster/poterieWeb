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
}

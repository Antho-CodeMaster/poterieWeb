<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat_article extends Model
{
    use HasFactory;
    protected $table = "etats_article";
    protected $primaryKey = "id_etat";
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compagnie_livraison extends Model
{
    use HasFactory;
    protected $table = 'compagnies_livraison';
    protected $primaryKey ='id_compagnie';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_livraison extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'photos_livraison';
}

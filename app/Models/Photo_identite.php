<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_identite extends Model
{
    use HasFactory;
    protected $table = "photos_identite";
    protected $fillable = ['id_demande, path'];
    public $timestamps = false;
    protected $primaryKey = "id_photo";
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_article extends Model
{
    use HasFactory;
    protected $table = "photos_article";
    protected $primaryKey = "id_photo";
    public $timestamps = false;
}

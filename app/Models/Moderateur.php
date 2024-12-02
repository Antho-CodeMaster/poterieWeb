<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderateur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_moderateur';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'is_admin'
    ];
}

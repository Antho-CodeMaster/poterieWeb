<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderateur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_moderateur';

    protected $fillable = [
        'id_user',
        'is_admin'
    ];
}

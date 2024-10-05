<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = ['id_type', 'id_etat', 'id_user', 'date'];
    protected $primaryKey = "id_demande";
    protected $table = "demandes";
}

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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function etat()
    {
        return $this->belongsTo(Etat_demande::class, 'id_etat', 'id_etat');
    }

    public function type()
    {
        return $this->belongsTo(Type_demande::class, 'id_type', 'id_type');
    }

    public function photos_oeuvres()
    {
        return $this->hasMany(Photo_oeuvre::class, 'id_demande', 'id_demande');
    }

    public function photos_identite()
    {
        return $this->hasMany(Photo_identite::class, 'id_demande', 'id_demande');
    }
}

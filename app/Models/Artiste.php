<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artiste extends Model
{
    use HasFactory;
    protected $table = "artistes";
    protected $primaryKey = "id_artiste";

    public function reseaux() {
        return $this->belongsToMany(Reseau::class, "reseaux_artistes", 'id_artiste', 'id_reseau')->withPivot('username');
    }
}


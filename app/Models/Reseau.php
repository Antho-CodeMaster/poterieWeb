<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reseau extends Model
{
    use HasFactory;
    protected $table = "reseaux";
    protected $primaryKey = "id_reseau";

    public function artistes(): BelongsToMany
    {
        return $this->belongsToMany(Artiste::class, 'reseaux_artistes', "id_reseau", "id_artiste")->withPivot('username');
    }
}

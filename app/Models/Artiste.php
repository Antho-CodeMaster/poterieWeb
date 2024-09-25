<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artiste extends Model
{
    use HasFactory;

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'id_user' , 'id');
    }

    public function articles() {
        return $this->hasMany(Article::class, 'id_artiste', 'id_artiste');
    }
}

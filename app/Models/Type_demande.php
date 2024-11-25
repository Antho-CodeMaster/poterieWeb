<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_demande extends Model
{
    use HasFactory;
    protected $table = "types_demande";
    public $timestamps = false;
}

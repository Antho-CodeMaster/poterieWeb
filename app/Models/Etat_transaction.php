<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat_transaction extends Model
{
    use HasFactory;

    protected $table = 'etats_transaction';
    public $timestamps = false;
}

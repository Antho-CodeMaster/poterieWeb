<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question_securite extends Model
{
    use HasFactory;
    protected $table = 'questions_securite';
    public $timestamps = false;
}

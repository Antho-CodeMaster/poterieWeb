<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $primary_key ='id_transaction';

    public function article_non_recu(){
        return $this->hasMany(Article_non_recu::class,'id_transaction');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_non_recu extends Model
{
    use HasFactory;
    protected $table = "articles_non_recus";
    protected $primaryKey = "id_signalement";
    protected $fillable = ['id_transaction', 'description', 'actif'];

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'id_transaction', 'id_transaction');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;
    protected $fillable = ['id_signalement', 'id_user', 'id_article', 'date', 'description'];
    protected $primaryKey = "id_signalement";
    protected $table = "signalements";
    public $timestamps = false;

    public function article(){
        return $this->belongsTo(Article::class,'id_article','id_article');
    }

    public function user(){
        return $this->belongsTo(User::class,'id_user','id');
    }
}

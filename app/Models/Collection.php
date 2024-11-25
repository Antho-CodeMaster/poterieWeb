<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $table = 'collections';
    protected $primaryKey = 'id_collection';
    protected $fillable = ['collection'];
    public $timestamps = false;

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'collections_articles', 'id_collection', 'id_article');
    }
}

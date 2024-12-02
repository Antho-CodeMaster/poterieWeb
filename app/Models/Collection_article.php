<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Collection_article extends Pivot
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'collections_articles';
}

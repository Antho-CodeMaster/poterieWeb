<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_notification extends Model
{
    use HasFactory;
    protected $table = 'types_notification';

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_type', 'id_type');
    }
}

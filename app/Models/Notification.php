<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $primaryKey = "id_notification";
    protected $fillable = ['id_type', 'id_user', 'date', 'message', 'lien', 'visible'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type_notification::class, 'id_type', 'id_type');
    }

    public function getFormattedDescriptionAttribute()
    {
        // Access the description template from the type_notification relationship
        $description = $this->type->description ?? '';

        // Replace placeholder [1] with the actual message
        return str_replace('[1]', $this->message, $description);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;
    protected $table = "users";
    protected $primaryKey = "id";

    public function likes()
    {
        return $this->hasMany(Like::class, 'id_user', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function artistes()
    {
        return $this->belongsTo(Artiste::class, "id_user", "id_user");
    }

    public function artiste()
    {
        return $this->hasOne(Artiste::class, 'id_user');
    }

    public function moderateur()
    {
        return $this->hasOne(Moderateur::class, 'id_user');
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_user', 'id');
    }

    public function avertissements()
    {
        return Notification::where('id_user', $this->id)->where('id_type', 2)->get();
    }

    public function is_admin(): bool
    {
        if (Moderateur::where('id_user', '=', $this->id)->first()->is_admin)
            return true;

        return false;
    }
}

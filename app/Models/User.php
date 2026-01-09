<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Ad; // ДОБАВЬТЕ ЭТУ СТРОКУ!

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ДОБАВЬТЕ ЭТИ МЕТОДЫ (если их нет):

    /**
     * Отношение: пользователь имеет много объявлений
     */
  public function ads() {
    return $this->hasMany(Ad::class);
}

    /**
     * Отношение: пользователь имеет много избранных объявлений
     */
    public function favorites()
    {
        return $this->belongsToMany(Ad::class, 'ad_user')->withTimestamps();
    }
}
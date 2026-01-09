<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'price', 
        'category_id', 
        'user_id'
    ];

    // ДОБАВЬТЕ ЭТИ МЕТОДЫ:

    /**
     * Отношение: объявление принадлежит пользователю
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Отношение: объявление принадлежит категории
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Отношение: объявление имеет много изображений
     */
    public function images()
    {
        return $this->hasMany(AdImage::class);
    }

    /**
     * Отношение: объявление имеет много пользователей, которые добавили его в избранное
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'ad_user')->withTimestamps();
    }
}
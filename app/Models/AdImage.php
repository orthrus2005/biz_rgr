<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdImage extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'ad_id'];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Ad $ad)
    {
        $user = Auth::user();

        // Проверяем наличие связи через метод favorites() [cite: 392]
        if ($user->favorites()->where('ad_id', $ad->id)->exists()) {
            $user->favorites()->detach($ad->id);
            $message = 'Удалено из избранного';
        } else {
            $user->favorites()->attach($ad->id);
            $message = 'Добавлено в избранное';
        }

        return back()->with('success', $message);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    // Общая доска объявлений
    public function index(Request $request)
{
    // Начинаем строить запрос
    $query = Ad::with(['category', 'images', 'user']);

    // Фильтр по названию (Поиск)
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Фильтр по категории (ВАЖНО: имя поля должно совпадать с name в <select>)
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Сортируем: сначала новые, и разбиваем на страницы
    $ads = $query->latest()->paginate(9);
    
    $categories = Category::all();
    
    return view('ads.index', compact('ads', 'categories'));
}

    // Страница "Мои объявления"
    public function myAds()
    {
        $ads = Auth::user()->ads()->latest()->get();
        return view('ads.my', compact('ads'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('ads.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:5|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|max:2048'
        ]);

        $ad = Auth::user()->ads()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('ads', 'public');
                $ad->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('ads.my')->with('success', 'Объявление создано!');
    }

    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        abort_if(Auth::id() !== $ad->user_id, 403);
        $categories = Category::all();
        return view('ads.edit', compact('ad', 'categories'));
    }

 public function update(Request $request, Ad $ad)
{
    // Проверка прав (только автор)
    abort_if(Auth::id() !== $ad->user_id, 403);

    $validated = $request->validate([
        'title' => 'required|min:5|max:255',
        'description' => 'required',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    // Обновляем текстовые данные
    $ad->update($validated);

    // Работа с фото
    if ($request->hasFile('images')) {
        // 1. Удаляем старые файлы с диска и из БД
        foreach ($ad->images as $oldImage) {
            Storage::disk('public')->delete($oldImage->path);
            $oldImage->delete();
        }

        // 2. Загружаем новые
        foreach ($request->file('images') as $file) {
            $path = $file->store('ads', 'public');
            $ad->images()->create(['path' => $path]);
        }
    }

    return redirect()->route('ads.my')->with('success', 'Объявление и фото обновлены!');
}

    public function destroy(Ad $ad)
    {
        abort_if(Auth::id() !== $ad->user_id, 403);
        $ad->delete();
        return back()->with('success', 'Удалено!');
    }
}
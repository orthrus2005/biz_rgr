@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-6">
                {{-- Вывод изображений --}}
                @if($ad->images->count() > 0)
                    <div id="adCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($ad->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100 rounded-start" alt="{{ $ad->title }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <img src="https://via.placeholder.com/600x400?text=Нет+фото" class="img-fluid rounded-start" alt="Нет изображения">
                @endif
            </div>
            
            <div class="col-md-6">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h1 class="card-title">{{ $ad->title }}</h1>
                        <span class="badge bg-primary">{{ $ad->category->name }}</span>
                    </div>
                    
                    <h3 class="text-success my-3">{{ number_format($ad->price, 0, '.', ' ') }} ₽</h3>
                    
                    <hr>
                    <h5>Описание:</h5>
                    <p class="card-text">{{ $ad->description }}</p>
                    <hr>
                    
                    <div class="text-muted mb-4">
                        <p class="mb-1"><strong>Продавец:</strong> {{ $ad->user->name }}</p>
                        <p class="mb-1"><strong>Дата публикации:</strong> {{ $ad->created_at->format('d.m.Y H:i') }}</p>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('ads.index') }}" class="btn btn-outline-secondary">Назад</a>
                        
                        {{-- Проверка авторизации: только автор видит кнопки управления --}}
                        @auth
                            @if(Auth::id() === $ad->user_id)
                                <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-warning">Редактировать</a>
                                <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Доска объявлений</h1>

    <form action="{{ route('ads.index') }}" method="GET" class="mb-4 p-3 bg-light rounded shadow-sm">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Что ищем?" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-control">
    <option value="">Все категории</option>
    @foreach($categories as $cat)
        {{-- request('category') подсвечивает выбранную категорию после перезагрузки --}}
        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
    @endforeach
</select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Найти</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($ads as $ad)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm"> {{-- h-100 делает все карточки одной высоты --}}
                    
                    <div style="height: 220px; width: 100%; overflow: hidden; background-color: #f8f9fa;">
                        @if($ad->images->count() > 0)
                            <img src="{{ asset('storage/' . $ad->images->first()->path) }}" 
                                 class="card-img-top w-100 h-100" 
                                 style="object-fit: cover;" {{-- Это ВАЖНО: картинка заполнит блок, не растягиваясь --}}
                                 alt="{{ $ad->title }}">
                        @else
                            {{-- Заглушка, если фото нет --}}
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <span>Нет фото</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate" title="{{ $ad->title }}">
                            {{ $ad->title }}
                        </h5>
                        
                        <p class="card-text text-muted" style="height: 3rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            {{ $ad->description }}
                        </p>
                        
                        <div class="mt-auto"> {{-- Прижимает цену и кнопку к низу --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-info text-dark">{{ $ad->category->name }}</span>
                                <strong class="text-success fs-5">{{ number_format($ad->price, 0, '.', ' ') }} ₽</strong>
                            </div>
                            <a href="{{ route('ads.show', $ad->id) }}" class="btn btn-outline-primary w-100">Подробнее</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $ads->appends(request()->input())->links() }} {{-- appends сохраняет поиск при переходе по страницам --}}
    </div>
</div>
@endsection
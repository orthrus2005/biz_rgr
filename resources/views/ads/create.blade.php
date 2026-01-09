@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Создать новое объявление</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. Название --}}
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 2. Категория (Выпадающий список) --}}
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Выберите категорию</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 3. Цена --}}
                        <div class="mb-3">
                            <label class="form-label">Цена (руб.)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                            @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 4. Описание (Текстовая область) --}}
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 5. Загрузка изображений (Файлы) --}}
                        <div class="mb-3">
                            <label class="form-label">Изображения</label>
                            <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple>
                            <small class="text-muted">Можно выбрать несколько файлов</small>
                            @error('images.*')
                                <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Опубликовать объявление</button>
                            <a href="{{ route('ads.index') }}" class="btn btn-outline-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
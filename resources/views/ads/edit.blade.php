@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white h5">Редактирование: {{ $ad->title }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ads.update', $ad->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Название, Категория, Цена --}}
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Название</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $ad->title) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Цена (₽)</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $ad->price) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category_id" class="form-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $ad->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $ad->description) }}</textarea>
                        </div>

                        {{-- СЕКЦИЯ ФОТО --}}
                        <div class="mb-4">
                            <label class="form-label"><strong>Фотографии</strong></label>
                            
                            {{-- Показываем текущие фото --}}
                            @if($ad->images->count() > 0)
                                <div class="d-flex flex-wrap gap-2 mb-3 p-2 border rounded bg-light">
                                    @foreach($ad->images as $img)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $img->path) }}" style="width: 80px; height: 80px; object-fit: cover;" class="rounded border">
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted d-block mb-2">Загрузка новых фото полностью заменит старые.</small>
                            @endif

                            <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple>
                            @error('images.*') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Сохранить изменения</button>
                            <a href="{{ route('ads.my') }}" class="btn btn-outline-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
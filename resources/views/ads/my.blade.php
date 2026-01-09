@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Мои объявления</h2>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ads as $ad)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $ad->images->first()?->path) }}" width="50">
                </td>
                <td>{{ $ad->title }}</td>
                <td>{{ $ad->price }} ₽</td>
                <td>
                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Моя статистика</h2>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Объявлений</h5>
                    <p class="card-text display-4">{{ $adCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Общая стоимость</h5>
                    <p class="card-text display-4">{{ number_format($totalValue, 0, '', ' ') }} ₽</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Средняя цена</h5>
                    <p class="card-text display-4">{{ number_format($averagePrice, 0, '', ' ') }} ₽</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Дорогих (>5000)</h5>
                    <p class="card-text display-4">{{ $expensiveAds->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <h3>Все объявления</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Категория</th>
                <th>Цена</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sortedByPrice as $ad)
            <tr>
                <td>{{ $ad->title }}</td>
                <td>{{ $ad->category->name }}</td>
                <td>{{ number_format($ad->price, 0, '', ' ') }} ₽</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Группировка по категориям</h3>
    @foreach($adsByCategory as $categoryName => $ads)
        <h4>{{ $categoryName }} ({{ $ads->count() }})</h4>
        <ul>
            @foreach($ads as $ad)
                <li>{{ $ad->title }} - {{ number_format($ad->price, 0, '', ' ') }} ₽</li>
            @endforeach
        </ul>
    @endforeach
</div>
@endsection
@extends('layouts.app')
@php
$stats = json_decode($character->stats, true);
@endphp
@section('content')
<div class="container">
    <div class="character-card">
        <div class="character-header">
            <img src="{{ asset('storage/' . $character->image_path) }}" alt="{{ $character->name }}" class="character-image">
            <div class="character-info">
                <h1>{{ $character->name }}</h1>
                <p><strong>Race:</strong> {{ $character->race }}</p>
                <p><strong>Class:</strong> {{ $character->class }}</p>
                <p><strong>Alignment:</strong> {{ $character->alignment }}</p>
                <p><strong>Background:</strong> {{ $character->background }}</p>
                <p><strong>Experience:</strong> 100/100 (placeholder)</p>
                <a href="{{ route('characters.edit', $character->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <div class="character-stats">
            <h2>Stats</h2>
            <div class="stats-grid">

                @foreach($stats as $stat => $value)
                    <div class="stat-box">
                        <p>{{ ucfirst($stat) }}</p>
                        <p>{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <h2>Hit Points</h2>
            <div class="hp-box">
                <p>Current: {{ $character->hitpoints }}</p>
                <p>Max: 25 (placeholder)</p>
            </div>
        </div>
    </div>
</div>

<style>
    .character-card {
        background-color: #2c2f33;
        padding: 20px;
        border-radius: 10px;
        color: white;
    }
    .character-header {
        display: flex;
        align-items: center;
    }
    .character-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
    }
    .stat-box {
        background-color: #23272a;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
    }
    .hp-box {
        background-color: #7289da;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
</style>
@endsection

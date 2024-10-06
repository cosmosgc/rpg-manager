@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $item->name }}</h1>

        <div class="mb-3">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="img-fluid">
        </div>

        <p><strong>Description:</strong> {{ $item->description }}</p>
        <p><strong>Quantity:</strong> {{ $item->quantity }}</p>

        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">Edit</a>

        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
@endsection

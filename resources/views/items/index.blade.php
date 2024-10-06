@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Items</h1>
        <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Create New Item</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($items->isEmpty())
            <p>No items available.</p>
        @else
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                                <a href="{{ route('items.show', $item) }}" class="btn btn-info">View</a>
                                <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">Edit</a>

                                <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

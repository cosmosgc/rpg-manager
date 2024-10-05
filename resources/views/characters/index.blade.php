@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Character List</h1>
            <a href="{{ route('characters.create') }}" class="btn btn-primary">Create Character</a>
        </div>

        <div class="list-group">
            @foreach($characters as $character)
                <a href="{{ route('characters.show', $character->id) }}" class="list-group-item list-group-item-action">
                    <img src="{{ asset('storage/' . $character->image_path) }}" alt="{{ $character->name }}" width="50" height="50">
                    <strong>{{ $character->name }}</strong> - {{ $character->class }} - {{ $character->race }}
                </a>
            @endforeach
        </div>
    </div>
@endsection

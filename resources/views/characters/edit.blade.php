@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Character: {{ $character->name }}</h1>

    <form action="{{ route('characters.update', $character->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $character->name }}">
        </div>

        <div class="form-group">
            <label for="race">Race</label>
            <input type="text" name="race" class="form-control" value="{{ $character->race }}">
        </div>

        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" class="form-control" value="{{ $character->class }}">
        </div>

        <div class="form-group">
            <label for="alignment">Alignment</label>
            <input type="text" name="alignment" class="form-control" value="{{ $character->alignment }}">
        </div>

        <div class="form-group">
            <label for="background">Background</label>
            <textarea name="background" class="form-control">{{ $character->background }}</textarea>
        </div>

        <div class="form-group">
            <label for="hitpoints">Hitpoints</label>
            <input type="number" name="hitpoints" class="form-control" value="{{ $character->hitpoints }}">
        </div>

        <div class="form-group">
            <label for="mana">Mana</label>
            <input type="number" name="mana" class="form-control" value="{{ $character->mana }}">
        </div>

        <div class="form-group">
            <label for="image_path">Character Image</label>
            <input type="file" name="image_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection

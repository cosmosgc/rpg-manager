@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Character</h1>

        <form action="{{ route('characters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="race">Race</label>
                <input type="text" name="race" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="class">Class</label>
                <input type="text" name="class" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="alignment">Alignment</label>
                <input type="text" name="alignment" class="form-control">
            </div>

            <div class="form-group">
                <label for="background">Background</label>
                <textarea name="background" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="hitpoints">Hitpoints</label>
                <input type="number" name="hitpoints" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="mana">Mana</label>
                <input type="number" name="mana" class="form-control">
            </div>

            <div class="form-group">
                <label for="image_path">Character Image</label>
                <input type="file" name="image_path" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create Character</button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Skill: {{ $skill->name }}</h1>

    <form action="{{ route('skills.update', $skill->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Skill Name</label>
            <input type="text" name="name" class="form-control" value="{{ $skill->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $skill->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="image_path">Skill Image</label>
            <input type="file" name="image_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection

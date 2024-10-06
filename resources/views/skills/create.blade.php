@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Skill</h1>

    <form action="{{ route('skills.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Skill Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image_path">Skill Image</label>
            <input type="file" name="image_path" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create Skill</button>
    </form>
</div>
@endsection

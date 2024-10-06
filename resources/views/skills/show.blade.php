@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $skill->name }}</h1>
    <div class="skill-details">
        <img src="{{ asset('storage/' . $skill->image_path) }}" alt="{{ $skill->name }}" class="skill-image">
        <p><strong>Description:</strong> {{ $skill->description }}</p>
    </div>

    <a href="{{ route('skills.edit', $skill->id) }}" class="btn btn-primary">Edit Skill</a>
    <a href="{{ route('skills.index') }}" class="btn btn-secondary">Back to Skills List</a>
</div>
@endsection

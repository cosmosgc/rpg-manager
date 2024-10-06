@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Skills List</h1>

    <a href="{{ route('skills.create') }}" class="btn btn-primary mb-3">Create New Skill</a>

    <div class="list-group">
        @foreach($skills as $skill)
            <div class="list-group-item list-group-item-action">
                <a href="{{ route('skills.show', $skill->id) }}">
                    <img src="{{ asset('storage/' . $skill->image_path) }}" alt="{{ $skill->name }}" width="50" height="50">
                    <strong>{{ $skill->name }}</strong> - {{ $skill->description }}
                </a>

                <a href="{{ route('skills.edit', $skill->id) }}" class="btn btn-sm btn-secondary">Edit</a>
            </div>
        @endforeach

    </div>
</div>
@endsection

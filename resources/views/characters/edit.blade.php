@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Edit Character: {{ $character->name }}</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('characters.update', $character->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Character Details Section -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Character Details</div>
                    <div class="card-body">
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
                            <textarea name="background" class="form-control" rows="3">{{ $character->background }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">Character Stats</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="hitpoints">Hitpoints</label>
                            <input type="number" name="hitpoints" class="form-control" value="{{ $character->hitpoints }}">
                        </div>

                        <div class="form-group">
                            <label for="mana">Mana</label>
                            <input type="number" name="mana" class="form-control" value="{{ $character->mana }}">
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="strength">Strength</label>
                                <input type="number" name="strength" class="form-control" value="{{ $character->strength }}">
                            </div>
                            <div class="col">
                                <label for="dexterity">Dexterity</label>
                                <input type="number" name="dexterity" class="form-control" value="{{ $character->dexterity }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="constitution">Constitution</label>
                                <input type="number" name="constitution" class="form-control" value="{{ $character->constitution }}">
                            </div>
                            <div class="col">
                                <label for="intelligence">Intelligence</label>
                                <input type="number" name="intelligence" class="form-control" value="{{ $character->intelligence }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="wisdom">Wisdom</label>
                                <input type="number" name="wisdom" class="form-control" value="{{ $character->wisdom }}">
                            </div>
                            <div class="col">
                                <label for="charisma">Charisma</label>
                                <input type="number" name="charisma" class="form-control" value="{{ $character->charisma }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Skills Section -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">Character Skills</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="skills">Assign Skills</label>
                            <select name="skills[]" id="skills" class="form-control" multiple>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}"
                                        {{ in_array($skill->id, $character->skills->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $skill->name }} (Level: {{ $skill->pivot->level ?? 1 }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Image Section -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">Character Image</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image_path">Upload New Image</label>
                            <input type="file" name="image_path" class="form-control">
                        </div>
                        @if ($character->image_path)
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $character->image_path) }}" alt="{{ $character->name }}" class="img-thumbnail" width="150">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <a href="{{ route('characters.show', $character->id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

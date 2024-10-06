@extends('layouts.app')
@php
$stats = json_decode($character->stats, true);
@endphp
@section('content')
<div class="container">
    <div class="character-card">
        <div class="character-header">
            <img src="{{ asset('storage/' . $character->image_path) }}" alt="{{ $character->name }}" class="character-image">
            <div class="character-info">
                <h1>{{ $character->name }}</h1>
                <p><strong>Race:</strong> {{ $character->race }}</p>
                <p><strong>Class:</strong> {{ $character->class }}</p>
                <p><strong>Alignment:</strong> {{ $character->alignment }}</p>
                <p><strong>Background:</strong> {{ $character->background }}</p>
                <p><strong>Experience:</strong> {{$character->exp}}</p>
                <a href="{{ route('characters.edit', $character->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <div class="character-stats">
            <h2>Stats</h2>
            <div class="stats-grid">
                <div class="stat-box">
                    <p>Strength</p>
                    <p>{{ $character->strength }}</p>
                </div>
                <div class="stat-box">
                    <p>Dexterity</p>
                    <p>{{ $character->dexterity }}</p>
                </div>
                <div class="stat-box">
                    <p>Constitution</p>
                    <p>{{ $character->constitution }}</p>
                </div>
                <div class="stat-box">
                    <p>Intelligence</p>
                    <p>{{ $character->intelligence }}</p>
                </div>
                <div class="stat-box">
                    <p>Wisdom</p>
                    <p>{{ $character->wisdom }}</p>
                </div>
                <div class="stat-box">
                    <p>Charisma</p>
                    <p>{{ $character->charisma }}</p>
                </div>
            </div>

            <h2>Hit Points</h2>
            <div class="hp-box">
                <p>Current: {{ $character->hitpoints }}</p>
                <p>Max: 25 (placeholder)</p>
            </div>
        </div>

        <div class="character-skills mt-5">
            <h2>Skills</h2>
            @if($character->skills->isNotEmpty())
                <ul class="list-group">
                    @foreach($character->skills as $skill)
                        <li class="list-group-item">
                            <strong>{{ $skill->name }}</strong> (Level: {{ $skill->pivot->level }}) - {{ $skill->description }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No skills assigned to this character.</p>
            @endif
        </div>
        <div class="character-skills mt-5">
            <h2>Skills</h2>
            @if($character->skills->isNotEmpty())
                <div class="skills-grid">
                    @foreach($character->skills as $skill)
                        <div class="skill-icon" tabindex="0"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            data-bs-content="<strong>{{ $skill->name }}</strong><br>Level: {{ $skill->pivot->level }}<br>{{ $skill->description }}">
                            <img src="{{ asset('storage/' . $skill->image_path) }}" alt="{{ $skill->name }}">

                            <!-- Display Level Below the Image -->
                            <p class="skill-level">Level: {{ $skill->pivot->level }}</p>

                            <!-- Remove Skill Form -->
                            <form action="{{ route('skills.remove', ['character' => $character->id, 'skill' => $skill->id]) }}" method="POST" class="remove-skill-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No skills assigned to this character.</p>
            @endif

            <!-- Add Skill Form -->
            <h3>Add Skill</h3>
            <form action="{{ route('skills.add', $character->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="skill_id">Choose Skill:</label>
                    <select name="skill_id" id="skill_id" class="form-control">
                        @foreach($availableSkills as $availableSkill)
                            <option value="{{ $availableSkill->id }}">{{ $availableSkill->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="level">Skill Level:</label>
                    <input type="number" name="level" id="level" class="form-control" min="1" max="20" value="1">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Add Skill</button>
            </form>
        </div>

        <div class="inventory mt-5">
            <h2>Inventory</h2>
            @if($character->inventory && $character->inventory->items->isNotEmpty())
                <div class="inventory-grid">
                    @foreach($character->inventory->items as $item)
                        <div class="inventory-item" tabindex="0"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            data-bs-html="true"
                            data-bs-content="<strong>{{ $item->name }}</strong><br>Quantity: {{ $item->pivot->quantity }}<br>{{ $item->description }}">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">

                            <!-- Display Quantity Below the Image -->
                            <p class="item-quantity">Quantity: {{ $item->pivot->quantity }}</p>

                            <!-- Remove Item Form -->
                            <form action="{{ route('inventory.remove', ['character' => $character->id, 'item' => $item->id]) }}" method="POST" class="remove-item-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No items in inventory.</p>
            @endif
        </div>

        <div class="add-item mt-5">
            <h2>Add Item to Inventory</h2>
            <form action="{{ isset($character->inventory) ? route('inventory.add', $character->inventory->id) : '#' }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="item">Select Item</label>
                    <select name="item_id" id="item" class="form-control">
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                </div>
                <button type="submit" class="btn btn-primary" {{ !isset($character->inventory) ? 'disabled' : '' }}>Add to Inventory</button>
            </form>

        </div>

    </div>
</div>


<style>
    .character-card {
        background-color: #2c2f33;
        padding: 20px;
        border-radius: 10px;
        color: white;
    }
    .character-header {
        display: flex;
        align-items: center;
    }
    .character-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
    }
    .stat-box {
        background-color: #23272a;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
    }
    .hp-box {
        background-color: #7289da;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
</style>
<style>
    .inventory-grid {
        display: grid;
        grid-template-columns: repeat(10, 1fr); /* Adjust the number of columns as needed */
        gap: 15px;
        margin-top: 15px;
    }

    .inventory-item {
        position: relative;
        text-align: center;
    }

    .inventory-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .remove-item-form {
        margin-top: 10px;
    }

    .btn-danger {
        font-size: 12px;
    }
</style>
@endsection

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
                <div class="skills-grid">
                    @foreach($character->skills as $skill)
                        <div>
                            <div class="skill-icon" tabindex="0"
                                data-bs-toggle="popover"
                                data-bs-trigger="hover focus"
                                data-bs-content="<strong>{{ $skill->name }}</strong><br>Level: {{ $skill->pivot->level }}<br>{{ $skill->description }}">
                                <img src="{{ asset('storage/' . $skill->image_path) }}" alt="{{ $skill->name }}">

                                <!-- Display Level Below the Image -->
                                <p class="skill-level">Level: {{ $skill->pivot->level }}</p>
                            </div>
                            <!-- Remove Skill Form -->
                            <form action="{{ route('skills.remove', ['character' => $character->id, 'skill' => $skill->id]) }}" method="POST" class="remove-skill-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        </div>

                    @endforeach
                </div>
            @else
                <p>Nenhuma skill nesse personagem.</p>
            @endif

            <!-- Add Skill Form -->
            <h3>Add Skill</h3>
            <form action="{{ route('skills.add', $character->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="skill_id">Escolha uma Skill:</label>
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
            <h2>Inventário</h2>
            @if($character->inventory && $character->inventory->items->isNotEmpty())
                <div class="inventory-grid">
                    @foreach($character->inventory->items as $item)
                    <div>
                        <div class="inventory-item" tabindex="0"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            data-bs-html="true"
                            data-bs-content="<strong>{{ $item->name }}</strong><br>Quantity: {{ $item->pivot->quantity }}<br>{{ $item->description }}">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">

                            <!-- Display Quantity Below the Image -->
                            <p class="item-quantity">Quantidade: {{ $item->pivot->quantity }}</p>
                        </div>
                        <!-- Remove Item Form -->
                        <form action="{{ route('inventory.remove', ['character' => $character->id, 'item' => $item->id]) }}" method="POST" class="remove-item-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                        </form>
                    </div>

                    @endforeach
                </div>
            @else
                <p>No items ao Inventário.</p>
            @endif
        </div>

        <div class="add-item mt-5">
            <h2>Add Item ao Inventário</h2>
            <form action="{{ isset($character->inventory) ? route('inventory.add', $character->inventory->id) : '#' }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="item">Selecionar Item</label>
                    <select name="item_id" id="item" class="form-control">
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                </div>
                <button type="submit" class="btn btn-primary" {{ !isset($character->inventory) ? 'disabled' : '' }}>adicionar ao inventário</button>
            </form>

        </div>

    </div>
</div>


<style>

</style>
<style>

</style>
@endsection

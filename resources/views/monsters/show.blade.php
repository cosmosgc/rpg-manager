@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $monster->name }}</h1>
        <p><strong>Meta:</strong> {{ $monster->meta }}</p>
        <p><strong>Armor Class:</strong> {{ $monster->{'Armor Class'} }}</p>
        <p><strong>Hit Points:</strong> {{ $monster->{'Hit Points'} }}</p>
        <p><strong>Speed:</strong> {{ $monster->Speed }}</p>

        <h4>Ability Scores</h4>
        <ul>
            <li><strong>Strength:</strong> {{ $monster->STR }} {{ $monster->STR_mod }}</li>
            <li><strong>Dexterity:</strong> {{ $monster->DEX }} {{ $monster->DEX_mod }}</li>
            <li><strong>Constitution:</strong> {{ $monster->CON }} {{ $monster->CON_mod }}</li>
            <li><strong>Intelligence:</strong> {{ $monster->INT }} {{ $monster->INT_mod }}</li>
            <li><strong>Wisdom:</strong> {{ $monster->WIS }} {{ $monster->WIS_mod }}</li>
            <li><strong>Charisma:</strong> {{ $monster->CHA }} {{ $monster->CHA_mod }}</li>
        </ul>

        <h4>Traits</h4>
        {!! $monster->Traits !!}

        <h4>Actions</h4>
        {!! $monster->Actions !!}

        @if(!empty($monster->{'Legendary Actions'}))
            <h4>Legendary Actions</h4>
            {!! $monster->{'Legendary Actions'} !!}
        @endif
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Monsters</h1>

        <!-- Search and Sort Form -->
        <form action="{{ route('monsters.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or meta" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="sort" class="form-control">
                        <option value="">Sort by</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="meta" {{ request('sort') == 'meta' ? 'selected' : '' }}>Meta</option>
                        <option value="Hit Points" {{ request('sort') == 'Hit Points' ? 'selected' : '' }}>Hit Points</option>
                        <option value="Armor Class" {{ request('sort') == 'Armor Class' ? 'selected' : '' }}>Armor Class</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="direction" class="form-control">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Menor para Maior</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Maior para Menor</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Apply</button>
                </div>
            </div>
        </form>

        <!-- Monster Grid -->
        <div class="row">
            @if($monsters->isEmpty())
                <div class="col-12">
                    <p>No monsters found.</p>
                </div>
            @else
                @foreach($monsters as $monster)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ $monster->img_url }}" class="card-img-top" alt="{{ $monster->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $monster->name }}</h5>
                                <p class="card-text">{{ $monster->meta }}</p>
                                <p class="card-text"><strong>HP:</strong> {{ $monster->{'Hit Points'} }}</p>
                                <p class="card-text"><strong>AC:</strong> {{ $monster->{'Armor Class'} }}</p>
                                <a href="{{ route('monsters.show', $monster->name) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

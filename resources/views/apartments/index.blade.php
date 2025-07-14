@extends('layouts')

@section('title', 'Available Apartments')

@section('content')
    <h1 class="mb-4">Available Apartments</h1>
        <a href="{{ route('apartments.create') }}" class="btn btn-success mb-3">Add New Apartment</a>

    @foreach($apartments as $apartment)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $apartment->title }}</h5>
                <p class="card-text">{{ $apartment->description }}</p>
                <p><strong>Price per Night:</strong> ${{ number_format($apartment->price_per_night, 2) }}</p>
                <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>

    <a href="{{ route('apartments.all_apartment') }}" class="btn btn-warning mb-3">Show All Apartments</a>

    @endforeach
@endsection

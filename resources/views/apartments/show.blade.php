@extends('layouts')

@section('title', $apartment->title)

@section('content')
    <h1>{{ $apartment->title }}</h1>
    <p>{{ $apartment->description }}</p>
    <p><strong>Address:</strong> {{ $apartment->address }}</p>
    <p><strong>Available From:</strong> {{ $apartment->available_from }}</p>
    <p><strong>Available To:</strong> {{ $apartment->available_to }}</p>
    <p><strong>Price per Night:</strong> ${{ number_format($apartment->price_per_night, 2) }}</p>
    <a href="{{ route('bookings.create' , $apartment->id) }}" class="btn btn-success"> book</a>
    <a href="{{ route('apartments.index') }}" class="btn btn-secondary">Back to List</a>
@endsection

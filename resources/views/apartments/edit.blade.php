@extends('layouts')

@section('title', 'Edit Apartment')

@section('content')
    <h1>Edit Apartment</h1>

    <form action="{{ route('apartments.update', $apartment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" value="{{ $apartment->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $apartment->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" value="{{ $apartment->address }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price_per_night" class="form-label">Price per Night</label>
            <input type="number" step="0.01" name="price_per_night" value="{{ $apartment->price_per_night }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="available_from" class="form-label">Available From</label>
            <input type="date" name="available_from" value="{{ $apartment->available_from }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="available_to" class="form-label">Available To</label>
            <input type="date" name="available_to" value="{{ $apartment->available_to }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('apartments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

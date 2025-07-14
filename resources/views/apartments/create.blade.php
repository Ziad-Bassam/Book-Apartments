@extends('layouts')

@section('title', 'Create Apartment')

@section('content')
    <h1>Create Apartment</h1>

    <form action="{{ route('apartments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price_per_night" class="form-label">Price per Night</label>
            <input type="number" step="0.01" name="price_per_night" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="available_from" class="form-label">Available From</label>
            <input type="date" name="available_from" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="available_to" class="form-label">Available To</label>
            <input type="date" name="available_to" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection

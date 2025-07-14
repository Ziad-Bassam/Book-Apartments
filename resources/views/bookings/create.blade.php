@extends('layouts')

@section('title', 'Create Booking')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="mb-4">Create New Booking</h1>

    <form action="{{ route('bookings.store', $apartment->id) }}" method="POST">
        @csrf
        <input name = "apartment_id" value= "{{ $apartment->id }}" hidden>
        <div class="mb-3">
            <label for="apartment_id" class="form-label">Apartment</label>
            <select name="apartment_id" id="apartment_id" class="form-control" disabled>
                <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Book Now</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

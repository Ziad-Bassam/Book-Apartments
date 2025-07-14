@extends('layouts')

@section('title', 'Edit Booking')

@section('content')
    <h1 class="mb-4">Edit Booking</h1>

    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $booking->start_date }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $booking->end_date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

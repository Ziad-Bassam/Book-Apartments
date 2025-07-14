@extends('layouts')

@section('title', 'Unpaid Bookings')

@section('content')
    <h1 class="mb-4">Unpaid Bookings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($bookings as $booking)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $booking->apartment->title }}</h5>
                <p class="card-text"><strong>Address:</strong> {{ $booking->apartment->address }}</p>
                <p class="card-text"><strong>From:</strong> {{ $booking->start_date }} <strong>To:</strong> {{ $booking->end_date }}</p>
                <p class="card-text"><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>

                <form action="{{ route('payments.pay', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to pay?')">
                    @csrf
                    <button type="submit" class="btn btn-success">Pay Now</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No unpaid bookings found.</div>
    @endforelse
@endsection

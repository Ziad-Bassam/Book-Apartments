@extends('layouts')

@section('title', 'Booking Details')

@section('content')

    @if (session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
    @endif
    <h1 class="mb-4">Booking Details</h1>



    <div class="card mt-4">
        <div class="card-body">
            <h4>Apartment : {{ $booking->apartment->title }}</h4>
            <p><strong>Address:</strong> {{ $booking->apartment->address }}</p>
            <p><strong>Start Date:</strong> {{ $booking->start_date }}</p>
            <p><strong>End Date:</strong> {{ $booking->end_date }}</p>
            <p><strong>Total Price:</strong> {{ $booking->total_price }} EGP</p>
            <p><strong>Payment Status:</strong> {{ $booking->status }}</p>
            <p><strong>Payment status:</strong> {{ $booking->payment_status }}</p>
        </div>
    </div>
    <br>

    @if (Auth::id() === $booking->apartment->user_id && $booking->status === 'pending')
        <a href="{{ route('apartments.my_bookings') }}" class="btn btn-success" >Bookings confirmation</a>
    @endif

    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>

    @auth
        @if (Auth::id() === $booking->user_id)
            <a href="{{ route('payments.unpaid') }}" class="btn btn-success">pay now</a>
        @endif
    @endauth

@endsection

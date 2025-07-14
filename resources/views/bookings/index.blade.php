@extends('layouts')

@section('title', 'My Bookings')

@section('content')
    <h1 class="mb-4">My Bookings</h1>

    @if($bookings->isEmpty())
        <p>You have no bookings.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Apartment</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->apartment->title }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>{{ number_format($booking->total_price, 2) }} EGP</td>
                        <td>{{ ucfirst($booking->payment_status) }}</td>
                        <td>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">View</a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

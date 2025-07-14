@extends('layouts')

@section('title', 'My Apartments and Bookings')

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



    <div class="container">
        <h2>Your apartments and bookings on them</h2>

        @foreach ($apartments as $apartment)
            <div class="card mt-4">
                <div class="card-header">
                    {{ $apartment->title }} - {{ $apartment->address }}
                </div>
                <div class="card-body">
                    @if ($apartment->bookings->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total price</th>
                                    <th>Status</th>
                                    <th>Payment status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apartment->bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->start_date }}</td>
                                        <td>{{ $booking->end_date }}</td>
                                        <td>{{ $booking->total_price }} EGP</td>
                                        <td>{{ $booking->status }}</td>

                                        <td>
                                            <form action="{{ route('bookings.update_payment_status', $booking->id) }}"
                                                method="POST" style="display: inline-flex;">
                                                @csrf
                                                <select name="payment_status" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="unpaid"
                                                        {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                                    </option>
                                                    <option value="partial"
                                                        {{ $booking->payment_status == 'partial' ? 'selected' : '' }}>
                                                        Partial</option>
                                                    <option value="paid"
                                                        {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                                    </option>
                                                </select>
                                            </form>
                                        </td>

                                        <td>
                                            @if ($booking->status === 'pending')
                                                <form action="{{ route('bookings.confirm', $booking->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm">Acceptance</button>
                                                </form>

                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm">reject</button>
                                                </form>
                                            @else
                                                <span class="text-muted">done</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">There are no bookings yet.</p>
                    @endif
                </div>
            </div>
        @endforeach

@endsection

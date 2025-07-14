@extends('layouts')

@section('title', 'Create Apartment')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">All Apartments</h1>

        <a href="{{ route('apartments.create') }}" class="btn btn-success mb-3">Add New Apartment</a>

        @if ($apartments->isEmpty())
            <div class="alert alert-info">No apartments found.</div>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Address</th>
                        <th>Price/Night (EGP)</th>
                        <th>Status</th>
                        <th>Available From</th>
                        <th>Available To</th>
                        @foreach ($apartments as $apartment)
                            @auth
                                @if (Auth::user()->role === 'admin' || Auth::id() === $apartment->user_id)
                                    <th>Actions</th>
                                @endif
                            @endauth
                        @endforeach

                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td>{{ $apartment->id }}</td>
                            <td>{{ $apartment->title }}</td>
                            <td>{{ $apartment->address }}</td>
                            <td>{{ $apartment->price_per_night }}</td>
                            <td>
                                <span
                                    class="badge
                                    @if ($apartment->status == 'available') bg-success
                                    @elseif($apartment->status == 'booked') bg-warning
                                    @else bg-danger @endif">
                                    {{ ucfirst($apartment->status) }}
                                </span>
                            </td>
                            <td>{{ $apartment->available_from }}</td>
                            <td>{{ $apartment->available_to }}</td>
                            @auth
                                @if (Auth::user()->role === 'admin' || Auth::id() === $apartment->user_id)
                                    <td>
                                        <a href="{{ route('apartments.show', $apartment->id) }}"
                                            class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('apartments.edit', $apartment->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this apartment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            @endauth

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

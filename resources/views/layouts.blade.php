<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Apartment Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-bottom: 80px;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container"> <a class="navbar-brand" href="{{ route('apartments.index') }}">Apartment Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"> <span
                    class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('apartments.my_bookings') }}">Bookings on My
                                Apartments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('apartments.create') }}">Add Apartment</a>
                        </li>

                        @if (Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.apartments.pending') }}">Pending Apartments</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav"> @guest <li class="nav-item"><a class="nav-link"
                                href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item"><span class="nav-link">Hi, {{ Auth::user()->name }}&nbsp;&nbsp;</span></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}"> @csrf <button
                                    class="btn btn-outline-light btn-sm">Logout</button> </form>
                    </li> @endguest
                </ul>
            </div>
        </div>
    </nav>
    {{-- Page Content --}}

    <div class="container"> {{-- Flash Messages --}} @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show"> {{ session('success') }} <button
                    type="button" class="btn-close" data-bs-dismiss="alert"></button> </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Please fix the following issues:
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Main Section --}}
        @yield('content')
    </div>

    {{-- Footer --}}

    <footer>
        <div class="container"> <small>&copy; {{ date('Y') }}Apartment reservation system. All rights reserved to
                Ziad Aliwa.</small> </div>
    </footer>
    {{-- Bootstrap JS --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

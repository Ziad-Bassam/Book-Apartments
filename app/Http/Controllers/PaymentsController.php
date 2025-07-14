<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    public function unpaid()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->where('payment_status', 'unpaid')
            ->with('apartment')
            ->get();

        return view('payments.unpaid', compact('bookings'));
    }

    public function pay($booking_id)
    {
        $booking = Booking::where('id', $booking_id)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'unpaid')
            ->firstOrFail();

        $booking->update([
            'payment_status' => 'paid',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Payment successful!');
    }
}

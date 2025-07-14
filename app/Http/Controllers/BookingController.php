<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('apartment')->where('user_id', Auth::id())->get();
        return view('bookings.index', compact('bookings'));
    }


    public function create($apartment_id)
    {
        $apartment = Apartment::findOrFail($apartment_id);

        return view('bookings.create', compact('apartment'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'apartment_id' => 'required|exists:apartments,id',
        ]);

        $apartment = Apartment::findOrFail($request->apartment_id);

        $hasConfirmedBooking = Booking::where('apartment_id', $apartment->id)
            ->where('status', 'confirmed')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($hasConfirmedBooking) {
            return redirect()->back()->withErrors(['error' => 'This apartment is already confirmed for the selected period. Please choose another date. ']);
        }

        $days = now()->parse($request->start_date)->diffInDays(now()->parse($request->end_date)) + 1;
        $total = $days * $apartment->price_per_night;

        Booking::create([
            'user_id' => Auth::id(),
            'apartment_id' => $apartment->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $total,
            'payment_status' => 'unpaid',
            'status' => 'pending', // أو خليها حسب ما تحب
            'payment_deadline' => now()->addDays(2),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }


    public function show(Booking $booking)
    {
        //$this->authorizeAccess($booking);

        return view('bookings.show', compact('booking'));
    }


    public function destroy(Booking $booking)
    {
        $this->authorizeAccess($booking);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully');
    }

    private function authorizeAccess(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
    }


    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        $apartment = $booking->apartment;

        if ($apartment->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to confirm this booking.');
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->status = 'confirmed';
        $booking->save();

        Booking::where('id', '!=', $booking->id)
            ->where('apartment_id', $booking->apartment_id)
            ->where('status', 'pending')
            ->where(function ($query) use ($booking) {
                $query->whereBetween('start_date', [$booking->start_date, $booking->end_date])
                    ->orWhereBetween('end_date', [$booking->start_date, $booking->end_date])
                    ->orWhere(function ($q) use ($booking) {
                        $q->where('start_date', '<=', $booking->start_date)
                            ->where('end_date', '>=', $booking->end_date);
                    });
            })
            ->update(['status' => 'canceled']);

        return redirect()->route('bookings.index')->with('success', 'Booking confirmed successfully. Other conflicting bookings have been canceled.');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $this->authorizeAccessToOwner($booking);
        $booking->update(['status' => 'canceled']);
        return back()->with('success', 'Your reservation has been cancelled');
    }

    private function authorizeAccessToOwner(Booking $booking)
    {
        if ($booking->apartment->user_id !== Auth::id()) {
            abort(403);
        }
    }


    public function updatePaymentStatus(Request $request, $id){
        $request->validate([
        'payment_status' => 'required|in:unpaid,partial,paid',
        ]);

        $booking = Booking::findOrFail($id);
        if ($booking->apartment->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Payment status updated successfully');


    }

}

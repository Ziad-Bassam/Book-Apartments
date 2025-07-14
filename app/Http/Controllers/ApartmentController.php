<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{

    public function all_apartment()
    {
        $apartments = Apartment::where('admin_approve', true)->paginate(5);
        return view('apartments.all_apartment', compact('apartments'));
    }


    public function index()
    {
        $apartments = Apartment::where('admin_approve', true)
            ->where('status', 'available')
            ->get();

        return view('apartments.index', compact('apartments'));
    }



    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }




    public function create()
    {
        return view('apartments.create');
    }






    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'price_per_night' => 'required|numeric',
            'available_from' => 'required|date',
            'available_to' => 'required|date|after_or_equal:available_from',
        ]);

        $validated['user_id'] = Auth::id() ?? 1;

        Apartment::create($validated);

        return redirect()->route('apartments.index')->with('success', 'Apartment added successfully');
    }


    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);

        if ($apartment->user_id != Auth::id()) {
            abort(403);
        }

        return view('apartments.edit', compact('apartment'));
    }

    public function update(Request $request, $id)
    {
        $apartment = Apartment::findOrFail($id);

        if ($apartment->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'address' => 'sometimes|string',
            'price_per_night' => 'sometimes|numeric',
            'available_from' => 'sometimes|date',
            'available_to' => 'sometimes|date|after_or_equal:available_from',
        ]);

        $apartment->update($validated);

        return redirect()->route('apartments.index')->with('success', 'Apartment successfully modified');
    }

    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);

        if ($apartment->user_id != Auth::id()) {
            abort(403);
        }

        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully');
    }



    public function myApartmentsWithBookings(){
        $user = Auth::user();
        $apartments = $user->apartments()->with('bookings.user')->get();
        return view('apartments.my_bookings', compact('apartments'));
    }
}

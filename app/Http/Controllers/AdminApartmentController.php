<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class AdminApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::where('admin_approve', false)->get();
        return view('admin.apartments.pending', compact('apartments'));
    }

    public function approve(Apartment $apartment)
    {
        $apartment->admin_approve = true;
        $apartment->save();

        return redirect()->route('admin.apartments.pending')->with('success', 'Apartment approved successfully.');
    }


    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('admin.apartments.pending')->with('success', 'Apartment rejected and deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['quote.origin', 'quote.country', 'departure'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.create', compact('quote'));
    }

    public function store(Request $request, Quote $quote)
    {
        // Security check
        if ($quote->user_id !== Auth::id()) {
            abort(403);
        }

        if ($quote->status === 'booked') {
            return back()->with('error', 'This quote has already been booked.');
        }

        $request->validate([
            'drop_off_date' => 'required|date|after_or_equal:today',
        ]);

        $booking = Booking::create([
            'quote_id' => $quote->id,
            'user_id' => Auth::id(),
            'booking_number' => 'HL-' . strtoupper(Str::random(8)),
            'drop_off_date' => $request->drop_off_date,
            'status' => 'pending',
        ]);

        $quote->update(['status' => 'booked']);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully. Our team will contact you for drop-off details.');
    }
}

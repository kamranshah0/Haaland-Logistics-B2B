<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rate;
use App\Models\RateTier;
use App\Models\Departure;
use App\Models\Warehouse;
use App\Models\Country;
use App\Models\Region;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::where('role', 'client')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function rates()
    {
        $rates = Rate::with(['origin', 'country', 'region', 'tiers'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $warehouses = Warehouse::all();
        $countries = Country::all();
        $regions = Region::all();

        return view('admin.rates', compact('rates', 'warehouses', 'countries', 'regions'));
    }

    public function storeRate(Request $request)
    {
        $request->validate([
            'origin_id' => 'required|exists:warehouses,id',
            'country_id' => 'required|exists:countries,id',
            'service' => 'required|string',
            'service_type' => 'required|string',
            'tiers' => 'required|array',
            'tiers.*.min_volume' => 'required|numeric',
            'tiers.*.price_per_cft' => 'required|numeric',
        ]);

        $rate = Rate::create([
            'origin_id' => $request->origin_id,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'service' => $request->service,
            'service_type' => $request->service_type,
        ]);

        foreach ($request->tiers as $tier) {
            RateTier::create([
                'rate_id' => $rate->id,
                'min_volume' => $tier['min_volume'],
                'price_per_cft' => $tier['price_per_cft'],
            ]);
        }

        return back()->with('success', 'Rate created successfully.');
    }

    public function updateRate(Request $request, Rate $rate)
    {
        $request->validate([
            'origin_id' => 'required|exists:warehouses,id',
            'country_id' => 'required|exists:countries,id',
            'service' => 'required|string',
            'service_type' => 'required|string',
            'tiers' => 'required|array',
            'tiers.*.min_volume' => 'required|numeric',
            'tiers.*.price_per_cft' => 'required|numeric',
        ]);

        $rate->update([
            'origin_id' => $request->origin_id,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'service' => $request->service,
            'service_type' => $request->service_type,
        ]);

        // Recreate tiers to ensure clean state
        $rate->tiers()->delete();
        foreach ($request->tiers as $tier) {
            RateTier::create([
                'rate_id' => $rate->id,
                'min_volume' => $tier['min_volume'],
                'price_per_cft' => $tier['price_per_cft'],
            ]);
        }

        return back()->with('success', 'Rate updated successfully.');
    }

    public function destroyRate(Rate $rate)
    {
        $rate->tiers()->delete();
        $rate->delete();

        return back()->with('success', 'Rate and associated tiers deleted successfully.');
    }

    public function departures()
    {
        $departures = Departure::withCount('bookings')
            ->orderBy('departure_date', 'asc')
            ->paginate(10);

        return view('admin.departures', compact('departures'));
    }

    public function storeDeparture(Request $request)
    {
        $request->validate([
            'vessel_name' => 'required|string|max:255',
            'voyage_number' => 'required|string|max:100',
            'cutoff_date' => 'required|date',
            'departure_date' => 'required|date|after:cutoff_date',
            'arrival_date' => 'required|date|after:departure_date',
            'capacity_cft' => 'required|numeric|min:1',
        ]);

        Departure::create([
            'vessel_name' => $request->vessel_name,
            'voyage_number' => $request->voyage_number,
            'cutoff_date' => $request->cutoff_date,
            'departure_date' => $request->departure_date,
            'arrival_date' => $request->arrival_date,
            'capacity_cft' => $request->capacity_cft,
            'status' => 'active',
        ]);

        return back()->with('success', 'Vessel departure published successfully.');
    }

    public function updateDeparture(Request $request, Departure $departure)
    {
        $request->validate([
            'vessel_name' => 'required|string|max:255',
            'voyage_number' => 'required|string|max:100',
            'cutoff_date' => 'required|date',
            'departure_date' => 'required|date|after:cutoff_date',
            'arrival_date' => 'required|date|after:departure_date',
            'capacity_cft' => 'required|numeric|min:1',
        ]);

        $departure->update($request->all());

        return back()->with('success', 'Vessel schedule updated successfully.');
    }

    public function destroyDeparture(Departure $departure)
    {
        if ($departure->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete a vessel with active bookings.');
        }

        $departure->delete();

        return back()->with('success', 'Vessel departure removed successfully.');
    }

    public function warehouses()
    {
        $warehouses = Warehouse::withCount('rates')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.warehouses', compact('warehouses'));
    }

    public function storeWarehouse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:warehouses',
            'address' => 'required|string',
        ]);

        Warehouse::create($request->all());

        return back()->with('success', 'Warehouse added successfully.');
    }

    public function updateWarehouse(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:warehouses,code,' . $warehouse->id,
            'address' => 'required|string',
        ]);

        $warehouse->update($request->all());

        return back()->with('success', 'Warehouse updated successfully.');
    }

    public function destroyWarehouse(Warehouse $warehouse)
    {
        if ($warehouse->rates()->count() > 0) {
            return back()->with('error', 'Cannot delete a warehouse that is linked to active shipping rates.');
        }

        $warehouse->delete();

        return back()->with('success', 'Warehouse deleted successfully.');
    }

    public function externalShipments()
    {
        $bookings = Booking::whereNull('quote_id')
            ->with(['user', 'departure'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $users = User::where('role', 'client')->get();
        $departures = Departure::where('status', 'active')->get();

        return view('admin.external_shipments', compact('bookings', 'users', 'departures'));
    }

    public function storeExternalShipment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'external_reference' => 'required|string',
            'external_volume_cft' => 'required|numeric|min:0.1',
            'drop_off_date' => 'required|date',
        ]);

        Booking::create([
            'user_id' => $request->user_id,
            'booking_number' => 'EXT-' . strtoupper(Str::random(8)),
            'external_reference' => $request->external_reference,
            'external_volume_cft' => $request->external_volume_cft,
            'drop_off_date' => $request->drop_off_date,
            'status' => 'received',
            'departure_id' => $request->departure_id,
        ]);

        return back()->with('success', 'External shipment recorded successfully.');
    }

    public function approveUser(User $user)
    {
        $user->update(['status' => 'approved']);

        return back()->with('success', "User {$user->name} has been approved.");
    }

    public function rejectUser(User $user)
    {
        $user->update(['status' => 'rejected']);

        return back()->with('success', "User {$user->name} has been rejected.");
    }
}

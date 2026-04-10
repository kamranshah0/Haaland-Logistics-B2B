<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Warehouse;
use App\Models\Country;
use App\Services\LogisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    protected $logistics;

    public function __construct(LogisticsService $logistics)
    {
        $this->logistics = $logistics;
    }

    public function index()
    {
        $quotes = Auth::user()->quotes()
            ->with(['origin', 'country', 'region'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        // Only approved users can create formal quotes
        if (Auth::user()->status !== 'approved') {
            return redirect()->route('dashboard')->with('error', 'Your account must be approved to request quotes.');
        }

        $warehouses = Warehouse::all();
        $countries = Country::with('regions')->get();

        return view('quotes.create', compact('warehouses', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin_id' => 'required|exists:warehouses,id',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'nullable|exists:regions,id',
            'volume' => 'required|numeric|min:0.01',
            'volume_unit' => 'required|in:CBM,CFT',
            'service_type' => 'required|string',
        ]);

        $cft = $request->volume_unit === 'CBM' 
            ? $this->logistics->cbmToCft($request->volume) 
            : $request->volume;

        $calculation = $this->logistics->calculateQuote(
            (int)$request->origin_id,
            (int)$request->country_id,
            $request->region_id ? (int)$request->region_id : null,
            (float)$cft,
            $request->service_type
        );

        if (!$calculation['success']) {
            return back()->withInput()->with('error', $calculation['message']);
        }

        Quote::create([
            'user_id' => Auth::id(),
            'origin_id' => $request->origin_id,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'volume_cft' => $cft,
            'billable_volume_cft' => $calculation['billable_cft'],
            'rate_per_cft' => $calculation['rate_per_cft'],
            'total_price' => $calculation['total_price'],
            'service_type' => $request->service_type,
            'status' => 'active'
        ]);

        return redirect()->route('quotes.index')->with('success', 'Quote generated successfully.');
    }
}

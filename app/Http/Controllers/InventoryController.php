<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Carbon\Carbon;


class InventoryController extends Controller
{
    public function index()
    {
        $data['labels'] = Inventory::pluck('item_name');
        $data['data'] = Inventory::pluck('quantity');
        return view('Inventory.index', compact('data'));
    }

    public function update(Request $request)
    {
        foreach ($request->items as $item => $quantity) {
            Inventory::updateOrCreate(
                ['item_name' => $item, 'date' => $request->date],
                ['quantity' => $quantity]
            );
        }
        return redirect()->back()->with('success', 'Inventory updated!');
    }

    public function filter(Request $request)
{
    // Get the parameters from the request
    $date = $request->date;
    $type = $request->type;
    $startDate = $request->start_date;  // New start date for range filter
    $endDate = $request->end_date;  // New end date for range filter

    // Initialize the query for Inventory
    $query = Inventory::query();

    // Filter based on the 'type' (day or week)
    if ($type === 'day') {
        // Filter by a specific date
        $query->whereDate('date', Carbon::parse($date)->format('Y-m-d'));    
    } elseif ($type === 'week') {
        // Filter by a date range (start date to end date)
        $query->whereBetween('date', [
            Carbon::parse($startDate)->format('Y-m-d'),
            Carbon::parse($endDate)->format('Y-m-d')
        ]);
    }

    // Get filtered data (only 'date' and 'quantity' for the chart)
    $filteredData = $query->get(['date', 'quantity']);

    // Return filtered data as a JSON response
    return response()->json($filteredData);
    }
}
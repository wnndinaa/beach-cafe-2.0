<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Carbon\Carbon;


class InventoryController extends Controller
{
    public function index()
    {
        $filterCategory = request('category');
        $filterDate = request('date');

        $query = Inventory::query();

        if ($filterCategory && $filterCategory !== 'all') {
            $query->where('category', $filterCategory);
        }

        if ($filterDate) {
            $query->whereDate('date', $filterDate);
        }

        $inventories = $query->orderBy('category')
            ->orderBy('item_name')
            ->get();

        $categories = Inventory::distinct()->pluck('category')->sort();
        
        return view('Inventory.index', compact('inventories', 'categories', 'filterCategory', 'filterDate'));
    }

    public function create()
    {
        $itemNames = Inventory::distinct()->pluck('item_name')->sort();
        $categories = Inventory::distinct()->pluck('category')->sort();
        return view('Inventory.form', compact('itemNames', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'date' => 'required|date',
            'item_name_new' => 'nullable|string|max:255',
            'category_new' => 'nullable|string|max:255',
        ]);

        if ($request->item_name_new) {
            $validated['item_name'] = $request->item_name_new;
        }

        if ($request->category_new) {
            $validated['category'] = $request->category_new;
        }

        unset($validated['item_name_new'], $validated['category_new']);

        Inventory::create($validated);
        return redirect()->route('inventory.index')->with('success', 'Inventory item created successfully!');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $itemNames = Inventory::distinct()->pluck('item_name')->sort();
        $categories = Inventory::distinct()->pluck('category')->sort();
        return view('Inventory.form', compact('inventory', 'itemNames', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'date' => 'required|date',
            'item_name_new' => 'nullable|string|max:255',
            'category_new' => 'nullable|string|max:255',
        ]);

        if ($request->item_name_new) {
            $validated['item_name'] = $request->item_name_new;
        }

        if ($request->category_new) {
            $validated['category'] = $request->category_new;
        }

        unset($validated['item_name_new'], $validated['category_new']);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($validated);
        return redirect()->route('inventory.index')->with('success', 'Inventory item updated successfully!');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully!');
    }

    public function filter(Request $request)
    {
        $date = $request->date;
        $type = $request->type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Inventory::query();

        if ($type === 'day') {
            $query->whereDate('date', Carbon::parse($date)->format('Y-m-d'));    
        } elseif ($type === 'week') {
            $query->whereBetween('date', [
                Carbon::parse($startDate)->format('Y-m-d'),
                Carbon::parse($endDate)->format('Y-m-d')
            ]);
        }

        $filteredData = $query->get(['date', 'quantity']);
        return response()->json($filteredData);
    }
}

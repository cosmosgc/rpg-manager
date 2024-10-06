<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // List all items
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    // Show the form for creating a new item
    public function create()
    {
        return view('items.create');
    }

    // Store a newly created item in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'image' => 'nullable|image',
        ]);

        $item = new Item($validated);

        if ($request->hasFile('image')) {
            $item->image_path = $request->file('image')->store('items', 'public');
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item created successfully');
    }

    // Display a single item
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    // Show the form for editing an existing item
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    // Update the specified item in storage
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'image' => 'nullable|image',
        ]);

        $item->fill($validated);

        if ($request->hasFile('image')) {
            $item->image_path = $request->file('image')->store('items', 'public');
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }

    // Remove the specified item from storage
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }
}

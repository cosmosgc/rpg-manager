<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Character;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function addItem(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if the item already exists in the inventory
        $existingItem = $inventory->items()->where('item_id', $validated['item_id'])->first();

        if ($existingItem) {
            // If the item exists, update the quantity
            $inventory->items()->updateExistingPivot($validated['item_id'], [
                'quantity' => $existingItem->pivot->quantity + $validated['quantity']
            ]);
        } else {
            // Otherwise, add a new item
            $inventory->items()->attach($validated['item_id'], ['quantity' => $validated['quantity']]);
        }

        return redirect()->route('characters.show', $inventory->character_id)->with('success', 'Item added to inventory.');
    }
    public function removeItemFromInventory($characterId, $itemId)
    {
        $character = Character::findOrFail($characterId);
        $inventory = $character->inventory;

        if ($inventory) {
            $inventory->items()->detach($itemId); // Remove the item from the inventory
        }

        return redirect()->route('characters.show', $character->id)->with('success', 'Item removed from inventory.');
    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the party resources.
     */
    public function index()
    {
        // Return all party entries with their associated characters, ordered by the 'order' field
        $parties = Party::with('character')
                        ->orderBy('order') // Sort by 'order' field
                        ->get();

        return response()->json($parties, 200);
    }


    /**
     * Store a newly created party resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'party_index'=> $request->input('party_index', 0),
            'hitpoints' => $request->input('hitpoints', 10), // Default to 100 hitpoints if not provided
            'mana' => $request->input('mana', 10),           // Default to 50 mana if not provided
            'order' => $request->input('order', 1),          // Default to order 1 if not provided
        ]);
        // Validate the incoming request data
        $validated = $request->validate([
            'character_id' => 'required|exists:characters,id',
            'party_index' => 'required|integer',
            'hitpoints' => 'required|integer',
            'mana' => 'required|integer',
            'order' => 'required|integer',
        ]);

        // Create a new party entry
        $party = Party::create($validated);

        return response()->json($party, 201);
    }

    /**
     * Display the specified party resource.
     */
    public function show($id)
    {
        // Find the party by ID or return 404
        $party = Party::with('character')->findOrFail($id);

        return response()->json($party, 200);
    }

    /**
     * Update the specified party resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'character_id' => 'nullable|exists:characters,id',
            'party_index' => 'nullable|integer',
            'hitpoints' => 'nullable|integer',
            'mana' => 'nullable|integer',
            'order' => 'nullable|integer',
        ]);

        // Find the party entry
        $party = Party::findOrFail($id);

        // Update only the fields that are present in the request
        $party->fill($validated)->save();

        return response()->json($party, 200);
    }


    /**
     * Remove the specified party resource from storage.
     */
    public function destroy($id)
    {
        // Find the party entry and delete
        $party = Party::findOrFail($id);
        $party->delete();

        return response()->json(null, 204);
    }

    public function reorder(Request $request)
    {
        // Validate the input to ensure it's an array of objects with 'id' and 'order'
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:party,id',
            'order.*.order' => 'required|integer',
        ]);

        // Loop through each party character and update the order
        foreach ($validated['order'] as $partyData) {
            Party::where('id', $partyData['id'])
                ->update(['order' => $partyData['order']]);
        }

        return response()->json(['message' => 'Party order updated successfully!']);
    }
}

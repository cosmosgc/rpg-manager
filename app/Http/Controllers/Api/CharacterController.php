<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    // List all characters
    public function index()
    {
        $characters = Character::all();
        return response()->json($characters);
    }
    public function getAllCharacters()
    {
        return Character::all();
    }

    // Store a new character
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'strength' => 'required|integer',
            'dexterity' => 'required|integer',
            'constitution' => 'required|integer',
            'intelligence' => 'required|integer',
            'wisdom' => 'required|integer',
            'charisma' => 'required|integer',
            'hitpoints' => 'required|integer',
            'mana' => 'required|integer',
            'class' => 'required|string|max:255',
            'race' => 'required|string|max:255',
            'alignment' => 'required|string|max:255',
            'background' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
            'exp' => 'required|integer',
        ]);

        $character = Character::create($validatedData);
        return response()->json($character, 201); // 201 means "Created"
    }

    // Show a specific character by ID
    public function show($id)
    {
        // Fetch the character along with skills and inventory items
        $character = Character::with(['skills', 'inventory.items'])->find($id);

        if (!$character) {
            return response()->json(['message' => 'Character not found'], 404);
        }

        return response()->json($character);
    }

    // Update an existing character
    public function update(Request $request, $id)
    {
        $character = Character::find($id);

        if (!$character) {
            return response()->json(['message' => 'Character not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'strength' => 'sometimes|integer',
            'dexterity' => 'sometimes|integer',
            'constitution' => 'sometimes|integer',
            'intelligence' => 'sometimes|integer',
            'wisdom' => 'sometimes|integer',
            'charisma' => 'sometimes|integer',
            'hitpoints' => 'sometimes|integer',
            'mana' => 'sometimes|integer',
            'class' => 'sometimes|string|max:255',
            'race' => 'sometimes|string|max:255',
            'alignment' => 'sometimes|string|max:255',
            'background' => 'nullable|string',
            'image_path' => 'nullable|string|max:255',
            'exp' => 'sometimes|integer',
        ]);

        $character->update($validatedData);

        return response()->json($character);
    }

    // Delete a character
    public function destroy($id)
    {
        $character = Character::find($id);

        if (!$character) {
            return response()->json(['message' => 'Character not found'], 404);
        }

        $character->delete();

        return response()->json(['message' => 'Character deleted successfully']);
    }
}

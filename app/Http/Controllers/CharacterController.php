<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();  // Fetch all characters
        return view('characters.index', compact('characters'));
    }
    public function show($id)
    {
        $character = Character::findOrFail($id);  // Fetch specific character
        return view('characters.show', compact('character'));
    }



    public function create()
    {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'race' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'alignment' => 'nullable|string|max:255',
            'background' => 'nullable|string',
            'hitpoints' => 'required|integer',
            'mana' => 'nullable|integer',
            'image_path' => 'nullable|image|max:2048',  // Image upload validation
            'stats' => 'nullable|json',  // Include stats, allow null values
        ]);

        // Provide default value for 'stats' if not provided
        $validatedData['stats'] = $validatedData['stats'] ?? json_encode([
            'strength' => 0,
            'dexterity' => 0,
            'constitution' => 0,
            'intelligence' => 0,
            'wisdom' => 0,
            'charisma' => 0
        ]);

        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('characters', 'public');
        }

        Character::create($validatedData);

        return redirect()->route('characters.index')->with('success', 'Character created successfully!');
    }

    public function edit($id)
    {
        $character = Character::findOrFail($id);
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, $id)
    {
        $character = Character::findOrFail($id);
        $character->update($request->all());  // Update character with validated data
        return redirect()->route('characters.show', $character->id)->with('success', 'Character updated successfully!');
    }



    // Add other CRUD methods as needed
}


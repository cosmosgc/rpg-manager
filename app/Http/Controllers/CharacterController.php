<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Skill;
use App\Models\Item;
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
        $availableSkills = Skill::whereDoesntHave('characters', function ($query) use ($id) {
            $query->where('character_id', $id);
        })->get();
        $items = Item::all(); // Fetch all available items to add to inventory
        // In your controller, when loading the show view
        if (!$character->inventory) {
            $character->inventory()->create();  // Create an empty inventory
        }

        return view('characters.show', compact('character', 'items', 'availableSkills'));
    }
    public function getAllCharacters()
    {
        return Character::all();
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

            // Individual stat fields
            'strength' => 'nullable|integer|min:0',
            'dexterity' => 'nullable|integer|min:0',
            'constitution' => 'nullable|integer|min:0',
            'intelligence' => 'nullable|integer|min:0',
            'wisdom' => 'nullable|integer|min:0',
            'charisma' => 'nullable|integer|min:0',
        ]);

        // Provide default values for stats if not provided
        $validatedData['strength'] = $validatedData['strength'] ?? 0;
        $validatedData['dexterity'] = $validatedData['dexterity'] ?? 0;
        $validatedData['constitution'] = $validatedData['constitution'] ?? 0;
        $validatedData['intelligence'] = $validatedData['intelligence'] ?? 0;
        $validatedData['wisdom'] = $validatedData['wisdom'] ?? 0;
        $validatedData['charisma'] = $validatedData['charisma'] ?? 0;

        // Handle image upload if provided
        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('characters', 'public');
        }

        Character::create($validatedData);

        return redirect()->route('characters.index')->with('success', 'Character created successfully!');
    }


    public function edit($id)
    {
        $character = Character::findOrFail($id);
        $skills = Skill::all(); // Retrieve all available skills

        return view('characters.edit', compact('character', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $character = Character::findOrFail($id);
        // Update character details
        $character->update($request->all());

        // Sync the selected skills with the character
        $character->skills()->sync($request->skills);
        return redirect()->route('characters.show', $character->id)->with('success', 'Character updated successfully!');
    }



    // Add other CRUD methods as needed
}


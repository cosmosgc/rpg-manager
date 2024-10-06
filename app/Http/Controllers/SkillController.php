<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Character;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();
        return view('skills.index', compact('skills'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('skills.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('skills', 'public');
        }

        Skill::create($validatedData);

        return redirect()->route('skills.index')->with('success', 'Skill created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $skill = Skill::findOrFail($id);
        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('skills.edit', compact('skill'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $skill = Skill::findOrFail($id);

        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('skills', 'public');
        }

        $skill->update($validatedData);

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addSkill(Request $request, Character $character)
    {
        // Validate the request
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'level' => 'required|integer|min:1|max:20',
        ]);

        // Add the skill to the character with the specified level
        $character->skills()->attach($request->skill_id, ['level' => $request->level]);

        return redirect()->route('characters.show', $character->id)->with('success', 'Skill added successfully.');
    }

    // Remove a skill from the character
    public function removeSkill(Character $character, Skill $skill)
    {
        // Remove the skill
        $character->skills()->detach($skill->id);

        return redirect()->route('characters.show', $character->id)->with('success', 'Skill removed successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MonsterController extends Controller
{
    // Show all monsters in a grid view
    // In the MonsterController
    public function index(Request $request)
    {
        // Load the JSON file
        $json = Storage::disk('public')->get('srd_5e_monsters.json');
        $monsters = collect(json_decode($json));

        // Handle search
        if ($request->has('search')) {
            $search = $request->input('search');
            $monsters = $monsters->filter(function ($monster) use ($search) {
                return str_contains(strtolower($monster->name), strtolower($search)) ||
                    str_contains(strtolower($monster->meta), strtolower($search));
            });
        }

        // Handle sorting
        if ($request->has('sort') && $request->has('direction')) {
            $sort = $request->input('sort') ?? 'name';
            $direction = $request->input('direction') == 'asc' ? 'asc' : 'desc';

            $monsters = $monsters->sortBy(function ($monster) use ($sort) {
                return $this->parseSortableValue($monster->{$sort});
            }, SORT_REGULAR, $direction == 'desc');
        }

        return view('monsters.index', compact('monsters'));
    }

    // Helper function to parse and calculate values
    private function parseSortableValue($value)
    {
        // Check if the value is Hit Points or Armor Class and handle accordingly
        if (str_contains($value, 'd')) {
            // Example for Hit Points: "135 (18d10 + 36)"
            preg_match('/(\d+) \((\d+)d(\d+) \+ (\d+)\)/', $value, $matches);
            if ($matches) {
                // Calculate the maximum possible value from the dice roll
                $base = (int)$matches[1]; // 135
                $diceCount = (int)$matches[2]; // 18
                $diceSize = (int)$matches[3]; // 10
                $bonus = (int)$matches[4]; // 36
                return $base + ($diceCount * $diceSize) + $bonus; // 135 + (18 * 10) + 36
            }
        }

        // Fallback for values that are already integers or can be converted directly
        return (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }


    // Show details of a specific monster
    public function show($name)
    {
        // Load the JSON file
        $json = Storage::disk('public')->get('srd_5e_monsters.json');
        $monsters = json_decode($json);

        // Find the monster by name
        $monster = collect($monsters)->firstWhere('name', $name);

        if (!$monster) {
            abort(404, 'Monster not found');
        }

        return view('monsters.show', compact('monster'));
    }
}

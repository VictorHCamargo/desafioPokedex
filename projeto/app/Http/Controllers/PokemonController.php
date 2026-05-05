<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use Illuminate\Support\Facades\File;
class PokemonController extends Controller
{
    public function index()
    {
        $pokemons = Pokemon::all();
        return view('pokedex', compact('pokemons'));
    }

    public function view(int $id)
    {
        $pokemon = Pokemon::findOrFail($id);
        return view('pokemon.view', compact('pokemon'));
    }

    public function create()
    {
        return view('pokemon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|array',
            'types'  => 'required|array',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/pokemons'), $imageName);
            $imagePath = 'img/pokemons/' . $imageName;
        }

        Pokemon::create([
            'name'      => $request->name,
            'image_url' => $imagePath,
            'status'    => $request->status,
            'types'     => $request->types,
        ]);

        return redirect()->route('pokedex')->with('success', 'Pokémon cadastrado!');
    }

    public function edit(int $id)
    {
        $pokemon = Pokemon::findOrFail($id);
        return view('pokemon.edit', compact('pokemon'));
    }

    public function update(Request $request, int $id)
    {
        $pokemon = Pokemon::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|array',
            'types'  => 'required|array',
        ]);

        $data = $request->only(['name', 'status', 'types']);

        if ($request->hasFile('image')) {
            if ($pokemon->image_url && File::exists(public_path($pokemon->image_url))) {
                File::delete(public_path($pokemon->image_url));
            }

            $image     = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/pokemons'), $imageName);
            $data['image_url'] = 'img/pokemons/' . $imageName;
        }

        $pokemon->update($data);

        return redirect()->route('pokedex')->with('success', 'Pokémon atualizado!');
    }

    public function destroy(int $id)
    {
        $pokemon = Pokemon::findOrFail($id);

        if ($pokemon->image_url && File::exists(public_path($pokemon->image_url))) {
            File::delete(public_path($pokemon->image_url));
        }

        $pokemon->delete();

        return redirect()->route('pokedex')->with('success', 'Pokémon removido!');
    }
}

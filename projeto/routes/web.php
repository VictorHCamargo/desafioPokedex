<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;


Route::get('/pokedex/pokemon/create',[PokemonController::class, 'create'])->name('pokemon.create');

Route::get('/pokedex/{id}/view',[PokemonController::class, 'view'])->name('pokemon.view');

Route::get('/pokedex/{id}/edit',[PokemonController::class,'edit'])->name('pokemon.edit');

Route::post('/pokedex/pokemon/store',[PokemonController::class, 'store'])->name('pokemon.store');

Route::put('/pokedex/{id}/update',[PokemonController::class, 'update'])->name('pokemon.update');

Route::delete('/pokedex/{id}/delete',[PokemonController::class, 'destroy'])->name('pokemon.destroy');

Route::get('pokedex',[PokemonController::class,'index'])->name('pokedex');


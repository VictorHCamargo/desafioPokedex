<x-layouts.pokedex>


<x-layouts.pokemon title="'NOVO POKÉMON'">

    <div class="overflow-hidden rounded-2xl">
        <div class="flex w-[200%] transition-transform duration-500 ease-in-out" :class="view === 'list' ? '-translate-x-1/2' : 'translate-x-0'">
            
            <section class="w-1/2 px-0">
                <form action="{{ route('pokemon.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-xl">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Nome do Pokémon</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">Imagem Oficial</label>
                            <input type="file" name="image" required accept="image/*" class="w-full bg-slate-800 border border-slate-700 text-slate-300 rounded-xl px-4 py-2.5">
                            @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <x-types-pokemons />

                    <div class="mb-8 pt-4 border-t border-slate-800">
                        <label class="block text-slate-400 text-xs font-bold mb-3 uppercase tracking-wider">
                            Status Base
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach(['hp' => 'HP', 'attack' => 'Ataque', 'defense' => 'Defesa', 'special_attack' => 'Sp. Attack', 'special_defense' => 'Sp. Defense', 'speed' => 'Velocidade'] as $key => $label)
                            <div>
                                <span class="block text-slate-500 text-xs mb-1">{{ $label }}</span>
                                <input
                                    type="number" name="status[{{ $key }}]"
                                    value="{{ old('status.' . $key, 50) }}"
                                    min="1" max="255" required
                                    class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-2
                                           focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition"
                                >
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between items-center pt-4 border-t border-slate-800 gap-4">
                        <x-button-library />

                        <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-500 text-white font-bold px-8 py-3 rounded-xl transition-all">
                            Registrar Pokémon
                        </button>
                    </div>
                </form>
            </section>

            <x-library />

        </div>
    </div>
</x-layouts.pokemon>

<style>
    [x-cloak] { display: none !important; }
    .pixel { font-family: 'Press Start 2P', cursive; font-size: 0.7rem; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
</style>
</x-layouts.pokedex>
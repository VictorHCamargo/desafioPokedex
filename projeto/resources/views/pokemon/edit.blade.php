<x-layouts.pokedex>
    @php
        $currentTypes = $pokemon->types ?? [];
        $currentStatus = $pokemon->status ?? [];
    @endphp

    <x-layouts.pokemon title="'EDITAR POKÉMON: {{ strtoupper($pokemon->name) }}'">

        <div class="overflow-hidden rounded-2xl">
            <div class="flex w-[200%] transition-transform duration-500 ease-in-out" 
                 :class="view === 'list' ? '-translate-x-1/2' : 'translate-x-0'">
                
                <section class="w-1/2 px-0">
                    <form action="{{ route('pokemon.update', $pokemon->id) }}" method="POST" enctype="multipart/form-data" 
                          class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-xl">
                        @csrf
                        @method('PUT')

                        @if($pokemon->image_url)
                        <div class="mb-6 flex justify-center">
                            <div class="bg-slate-800/50 p-4 rounded-full border border-slate-700">
                                <img src="{{ asset($pokemon->image_url) }}" alt="{{ $pokemon->name }}" class="w-24 h-24 object-contain drop-shadow-lg">
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Nome do Pokémon</label>
                                <input type="text" name="name" value="{{ old('name', $pokemon->name) }}" required
                                       class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition">
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Nova Imagem (Opcional)</label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full bg-slate-800 border border-slate-700 text-slate-300 rounded-xl px-4 py-2.5 file:bg-amber-500/20 file:text-amber-400 file:border-0 file:rounded-full file:px-4 file:py-1 file:text-xs file:font-bold">
                                @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <x-types-pokemons :currentTypes="$currentTypes"/>

                        <div class="mb-8 pt-4 border-t border-slate-800">
                            <label class="block text-slate-400 text-xs font-bold mb-3 uppercase">Status Base</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach(['hp' => 'HP', 'attack' => 'Ataque', 'defense' => 'Defesa', 'special_attack' => 'Sp. Attack', 'special_defense' => 'Sp. Defense', 'speed' => 'Velocidade'] as $key => $label)
                                <div>
                                    <span class="block text-slate-500 text-xs mb-1">{{ $label }}</span>
                                    <input type="number" name="status[{{ $key }}]" value="{{ old('status.'.$key, $currentStatus[$key] ?? 50) }}" min="1" max="255" required
                                           class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none transition">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center pt-4 border-t border-slate-800 gap-4">

                            <x-button-library />

                            <button type="submit" class="w-full sm:w-auto bg-amber-600 hover:bg-amber-500 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all hover:scale-105">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </section>

                <x-library />

            </div>
        </div>
    </x-layouts.pokemon>
</x-layouts.pokedex>
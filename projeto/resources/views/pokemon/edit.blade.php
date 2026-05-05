<x-layouts.pokedex>
@php
    $availableTypes = ['normal', 'fire', 'water', 'grass', 'electric', 'ice', 'fighting', 'poison', 'ground', 'flying', 'psychic', 'bug', 'rock', 'ghost', 'dragon', 'dark', 'steel', 'fairy'];
    $currentTypes = $pokemon->types ?? [];
    $currentStatus = $pokemon->status ?? [];
@endphp

<main class="max-w-4xl mx-auto px-6 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h2 class="pixel text-amber-500 text-xl">EDITAR:</h2>
            <span class="text-white text-xl font-bold uppercase">{{ $pokemon->name }}</span>
        </div>
        <a href="{{ route('pokedex') }}" class="text-slate-400 hover:text-white transition font-bold text-sm">← Cancelar</a>
    </div>

    <form action="{{ route('pokemon.update', $pokemon->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-xl">
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
                <label class="block text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">Nome do Pokémon</label>
                <input type="text" name="name" value="{{ old('name', $pokemon->name) }}" required
                       class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">Nova Imagem (Opcional)</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full bg-slate-800 border border-slate-700 text-slate-300 rounded-xl px-4 py-2.5 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-amber-500/20 file:text-amber-400 hover:file:bg-amber-500/30 transition">
                @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-slate-400 text-xs font-bold mb-3 uppercase tracking-wider">Tipos</label>
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                @foreach($availableTypes as $type)
                <label class="flex items-center gap-2 bg-slate-800 border border-slate-700 px-3 py-2 rounded-lg cursor-pointer hover:border-slate-500 transition">
                    <input type="checkbox" name="types[]" value="{{ $type }}" class="text-amber-500 bg-slate-900 border-slate-700 rounded focus:ring-amber-500 focus:ring-offset-slate-800"
                           {{ in_array($type, old('types', $currentTypes)) ? 'checked' : '' }}>
                    <span class="text-sm text-slate-300 capitalize font-medium">{{ $type }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-slate-400 text-xs font-bold mb-3 uppercase tracking-wider">Status Base</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach(['hp' => 'HP', 'attack' => 'Ataque', 'defense' => 'Defesa', 'special_attack' => 'Sp. Attack', 'special_defense' => 'Sp. Defense', 'speed' => 'Velocidade'] as $key => $label)
                <div>
                    <span class="block text-slate-500 text-xs mb-1">{{ $label }}</span>
                    <input type="number" name="status[{{ $key }}]" value="{{ old('status.'.$key, $currentStatus[$key] ?? 50) }}" min="1" max="255" required
                           class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-2 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-800">
            <button type="submit" class="bg-amber-600 hover:bg-amber-500 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-amber-900/40 transition-all hover:scale-105 active:scale-95">
                Salvar Alterações
            </button>
        </div>
    </form>
</main>
</x-layouts.pokedex>
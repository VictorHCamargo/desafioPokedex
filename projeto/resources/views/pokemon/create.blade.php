<x-layouts.pokedex>
@php
    $availableTypes = ['normal', 'fire', 'water', 'grass', 'electric', 'ice', 'fighting', 'poison', 'ground', 'flying', 'psychic', 'bug', 'rock', 'ghost', 'dragon', 'dark', 'steel', 'fairy'];
@endphp

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

<main
    class="max-w-4xl mx-auto px-6 py-8"
    x-data="pokedexManager()"
    x-init="fetchList()"
>
    <div class="mb-6 flex items-center justify-between">
        <h2 class="pixel text-red-500 text-xl"
            x-text="view === 'form' ? 'NOVO POKÉMON' : 'BIBLIOTECA POKÉMON'">
        </h2>
        <a href="{{ route('pokedex') }}"
           class="text-slate-400 hover:text-white transition font-bold text-sm">
            ← Voltar para Pokédex
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl">
        <div
            class="flex w-[200%] transition-transform duration-500 ease-in-out"
            :class="view === 'list' ? '-translate-x-1/2' : 'translate-x-0'"
        >

            <section class="w-1/2 px-0">
                <form
                    action="{{ route('pokemon.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="bg-slate-900 border border-slate-800 rounded-2xl p-6 md:p-8 shadow-xl"
                >
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">
                                Nome do Pokémon
                            </label>
                            <input
                                type="text" name="name"
                                value="{{ old('name') }}" required
                                class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3
                                       focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition"
                            >
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">
                                Imagem Oficial
                            </label>
                            <input
                                type="file" name="image" required accept="image/*"
                                class="w-full bg-slate-800 border border-slate-700 text-slate-300 rounded-xl px-4 py-2.5
                                       file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0
                                       file:text-xs file:font-bold file:bg-red-500/20 file:text-red-400
                                       hover:file:bg-red-500/30 transition"
                            >
                            @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-slate-400 text-xs font-bold mb-3 uppercase tracking-wider">
                            Tipos (Selecione 1 ou 2)
                        </label>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                            @foreach($availableTypes as $type)
                            <label class="flex items-center gap-2 bg-slate-800 border {{ $errors->has('types') ? 'border-red-500/50' : 'border-slate-700' }} px-3 py-2
                                          rounded-lg cursor-pointer hover:border-slate-500 transition">
                                <input
                                    type="checkbox" name="types[]" value="{{ $type }}"
                                    class="text-red-500 bg-slate-900 border-slate-700 rounded"
                                    {{ is_array(old('types')) && in_array($type, old('types')) ? 'checked' : '' }}
                                >
                                <span class="text-sm text-slate-300 capitalize">{{ $type }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('types') <span class="text-red-500 text-[10px] mt-2 block font-bold">{{ $message }}</span> @enderror
                    </div>

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
                        <button
                            type="button"
                            @click="view = 'list'"
                            class="text-blue-400 hover:text-blue-300 font-bold text-sm flex items-center gap-2 group"
                        >
                            <span class="bg-blue-500/10 p-2 rounded-lg group-hover:bg-blue-500/20 transition">
                                🔍 Consultar Existentes
                            </span>
                        </button>

                        <button
                            type="submit"
                            class="w-full sm:w-auto bg-red-600 hover:bg-red-500 text-white font-bold
                                   px-8 py-3 rounded-xl shadow-lg shadow-red-900/40
                                   transition-all hover:scale-105 active:scale-95"
                        >
                            Registrar Pokémon
                        </button>
                    </div>
                </form>
            </section>

            <section class="w-1/2 px-0">
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl h-[700px] flex flex-col">

                    <div class="flex items-center gap-4 mb-6">
                        <button
                            @click="view = 'form'"
                            class="bg-slate-800 hover:bg-slate-700 text-white p-2 rounded-lg transition"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <div class="flex-1 relative">
                            <input
                                type="text" x-model="search"
                                placeholder="Filtrar por nome..."
                                class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl
                                       pl-10 pr-4 py-2 focus:ring-1 focus:ring-blue-500 outline-none"
                            >
                            <svg class="w-5 h-5 text-slate-500 absolute left-3 top-2.5"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <div class="flex bg-slate-800 rounded-lg p-1">
                            <button
                                @click="layout = 'grid'"
                                :class="layout === 'grid' ? 'bg-slate-700 text-blue-400' : 'text-slate-500'"
                                class="p-2 rounded-md transition"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                            <button
                                @click="layout = 'list'"
                                :class="layout === 'list' ? 'bg-slate-700 text-blue-400' : 'text-slate-500'"
                                class="p-2 rounded-md transition"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                        <template x-if="loading">
                            <div class="flex flex-col items-center justify-center h-full space-y-4">
                                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500"></div>
                                <p class="text-slate-500 pixel text-xs">Carregando Pokédex...</p>
                            </div>
                        </template>

                        <div :class="layout === 'grid' ? 'grid grid-cols-2 sm:grid-cols-3 gap-4' : 'flex flex-col gap-2'">
                            <template x-for="poke in filteredPokemon" :key="poke.name">
                                <div
                                    @click="fetchDetails(poke.name)"
                                    class="bg-slate-800/50 border border-slate-700 p-4 rounded-xl cursor-pointer
                                           hover:bg-slate-700 transition-all group flex items-center"
                                    :class="layout === 'grid' ? 'flex-col text-center' : 'flex-row justify-between'"
                                >
                                    <img
                                        :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${poke.id}.png`"
                                        class="w-16 h-16 group-hover:scale-110 transition-transform"
                                    >
                                    <span class="text-white font-bold capitalize text-sm" x-text="poke.name"></span>
                                    <span x-show="layout === 'list'" class="text-slate-500 text-xs">
                                        #<span x-text="poke.id"></span>
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <div
        x-show="modalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
        x-transition:enter="transition duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <div
            class="bg-slate-900 border border-slate-700 w-full max-w-md rounded-3xl overflow-hidden shadow-2xl"
            @click.away="modalOpen = false"
        >
            <template x-if="loadingDetail">
                <div class="p-20 flex flex-col items-center">
                    <div class="animate-bounce mb-4">
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" class="w-12">
                    </div>
                    <p class="text-white pixel text-xs">Acessando Dados...</p>
                </div>
            </template>

            <template x-if="!loadingDetail && selectedPoke">
                <div>
                    <div class="h-32 bg-gradient-to-b from-red-600 to-slate-900 relative">
                        <button @click="modalOpen = false" class="absolute top-4 right-4 text-white/50 hover:text-white">✕</button>
                        <img
                            :src="selectedPoke.sprites.other['official-artwork'].front_default"
                            class="w-40 h-40 absolute -bottom-10 left-1/2 -translate-x-1/2 drop-shadow-2xl"
                        >
                    </div>
                    <div class="pt-12 p-8 text-center">
                        <h3 class="text-2xl font-bold text-white capitalize mb-1" x-text="selectedPoke.name"></h3>
                        <div class="flex justify-center gap-2 mb-6">
                            <template x-for="t in selectedPoke.types">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase text-white bg-slate-800 border border-white/10"
                                      x-text="t.type.name">
                                </span>
                            </template>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-t border-slate-800 pt-6">
                            <template x-for="stat in selectedPoke.stats">
                                <div>
                                    <span class="block text-slate-500 text-[10px] uppercase font-bold"
                                          x-text="stat.stat.name.replace('special-', 'Sp. ')">
                                    </span>
                                    <span class="text-white font-bold" x-text="stat.base_stat"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</main>

<style>
    .pixel { font-family: 'Press Start 2P', cursive; font-size: 0.7rem; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>

<script>
function pokedexManager() {
    return {
        view: 'form',
        layout: 'grid',
        loading: false,
        loadingDetail: false,
        search: '',
        pokemonList: [],
        selectedPoke: null,
        modalOpen: false,

        async fetchList() {
            this.loading = true;
            try {
                const response = await fetch('https://pokeapi.co/api/v2/pokemon?limit=2000');
                const data = await response.json();
                this.pokemonList = data.results.map(p => {
                    const id = p.url.split('/').filter(Boolean).pop();
                    return { ...p, id };
                });
            } catch (e) { console.error('Erro ao carregar lista'); }
            this.loading = false;
        },

        get filteredPokemon() {
            if (!this.search) return this.pokemonList.slice(0, 50);
            return this.pokemonList
                .filter(p => p.name.toLowerCase().includes(this.search.toLowerCase()))
                .slice(0, 100);
        },

        async fetchDetails(name) {
            this.modalOpen = true;
            this.loadingDetail = true;
            try {
                const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${name}`);
                this.selectedPoke = await response.json();
            } catch (e) { console.error('Erro ao carregar detalhes'); }
            this.loadingDetail = false;
        }
    }
}
</script>

</x-layouts.pokedex>
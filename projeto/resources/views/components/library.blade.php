<section class="w-1/2 px-0" 
         x-init="$watch('view', v => { if (v === 'list' && pokemonList.length === 0) fetchList() })">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl h-[700px] flex flex-col">
        <div class="flex items-center gap-4 mb-6">
            <button @click="view = 'form'" class="bg-slate-800 hover:bg-slate-700 text-white p-2 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="flex-1 relative">
                <input type="text" x-model="search" placeholder="Filtrar por nome..."
                    class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl pl-10 pr-4 py-2 focus:ring-1 focus:ring-blue-500 outline-none">
                <svg class="w-5 h-5 text-slate-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="flex bg-slate-800 rounded-lg p-1">
                <button @click="layout = 'grid'" :class="layout === 'grid' ? 'bg-slate-700 text-blue-400' : 'text-slate-500'" class="p-2 rounded-md transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
                <button @click="layout = 'list'" :class="layout === 'list' ? 'bg-slate-700 text-blue-400' : 'text-slate-500'" class="p-2 rounded-md transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
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
                    <div @click="fetchDetails(poke.name)" class="bg-slate-800/50 border border-slate-700 p-4 rounded-xl cursor-pointer hover:bg-slate-700 transition-all group flex items-center"
                        :class="layout === 'grid' ? 'flex-col text-center' : 'flex-row justify-between'">
                        <img :src="`https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${poke.id}.png`" class="w-16 h-16 group-hover:scale-110 transition-transform">
                        <span class="text-white font-bold capitalize text-sm" x-text="poke.name"></span>
                        <span x-show="layout === 'list'" class="text-slate-500 text-xs">#<span x-text="poke.id"></span></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>

<template x-teleport="body">
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         x-transition.opacity
         x-cloak
         @click.away="modalOpen = false">
        
        <div class="bg-slate-900 border border-slate-700 w-full max-w-md rounded-3xl overflow-hidden shadow-2xl" @click.stop>
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
                        <button @click="modalOpen = false" class="absolute top-4 right-4 text-white/50 hover:text-white z-10">✕</button>
                        <img :src="selectedPoke.sprites.other['official-artwork'].front_default" 
                             class="w-40 h-40 absolute -bottom-10 left-1/2 -translate-x-1/2 drop-shadow-2xl">
                    </div>
                    <div class="pt-12 p-8 text-center">
                        <h3 class="text-2xl font-bold text-white capitalize mb-1" x-text="selectedPoke.name"></h3>
                        <div class="flex justify-center gap-2 mb-6">
                            <template x-for="t in selectedPoke.types">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase text-white bg-slate-800 border border-white/10" x-text="t.type.name"></span>
                            </template>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-t border-slate-800 pt-6">
                            <template x-for="stat in selectedPoke.stats">
                                <div>
                                    <span class="block text-slate-500 text-[10px] uppercase font-bold" x-text="stat.stat.name.replace('special-', 'Sp. ')"></span>
                                    <span class="text-white font-bold" x-text="stat.base_stat"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    if (typeof pokedexManager !== 'function') {
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
                    } catch (e) { console.error(e); }
                    this.loading = false;
                },
                get filteredPokemon() {
                    if (!this.search) return this.pokemonList.slice(0, 50);
                    return this.pokemonList.filter(p => p.name.toLowerCase().includes(this.search.toLowerCase())).slice(0, 100);
                },
                async fetchDetails(name) {
                    this.modalOpen = true;
                    this.loadingDetail = true;
                    try {
                        const response = await fetch(`https://pokeapi.co/api/v2/pokemon/${name}`);
                        this.selectedPoke = await response.json();
                    } catch (e) { console.error(e); }
                    this.loadingDetail = false;
                }
            }
        }
    }
</script>
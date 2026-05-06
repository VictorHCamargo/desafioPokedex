<main class="max-w-4xl mx-auto px-6 py-8" x-data="pokedexManager()" x-init="fetchList()">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="pixel text-red-500 text-xl" x-text="view === 'form' ? {{ $title }} : 'BIBLIOTECA POKÉMON'"></h2>
        <a href="{{ route('pokedex') }}" class="text-slate-400 hover:text-white transition font-bold text-sm">← Voltar</a>
    </div>

    {{ $slot }}

</main>
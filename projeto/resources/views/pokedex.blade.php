<x-layouts.pokedex>
@php
$typeColors = [
    'normal'   => ['bg'=>'bg-slate-500',   'text'=>'text-slate-100'],
    'fire'     => ['bg'=>'bg-orange-500',  'text'=>'text-white'],
    'water'    => ['bg'=>'bg-blue-500',    'text'=>'text-white'],
    'grass'    => ['bg'=>'bg-green-500',   'text'=>'text-white'],
    'electric' => ['bg'=>'bg-yellow-400',  'text'=>'text-slate-900'],
    'ice'      => ['bg'=>'bg-cyan-400',    'text'=>'text-slate-900'],
    'fighting' => ['bg'=>'bg-red-700',     'text'=>'text-white'],
    'poison'   => ['bg'=>'bg-purple-500',  'text'=>'text-white'],
    'ground'   => ['bg'=>'bg-amber-600',   'text'=>'text-white'],
    'flying'   => ['bg'=>'bg-indigo-400',  'text'=>'text-white'],
    'psychic'  => ['bg'=>'bg-pink-500',    'text'=>'text-white'],
    'bug'      => ['bg'=>'bg-lime-500',    'text'=>'text-slate-900'],
    'rock'     => ['bg'=>'bg-stone-500',   'text'=>'text-white'],
    'ghost'    => ['bg'=>'bg-violet-700',  'text'=>'text-white'],
    'dragon'   => ['bg'=>'bg-indigo-700',  'text'=>'text-white'],
    'dark'     => ['bg'=>'bg-slate-700',   'text'=>'text-white'],
    'steel'    => ['bg'=>'bg-slate-400',   'text'=>'text-slate-900'],
    'fairy'    => ['bg'=>'bg-pink-300',    'text'=>'text-slate-900'],
];

$statColor = fn($v) => $v >= 150 ? 'bg-blue-500' : ($v >= 110 ? 'bg-green-500' : ($v >= 70 ? 'bg-yellow-400' : ($v >= 40 ? 'bg-orange-500' : 'bg-red-500')));
@endphp

<header class="bg-slate-900 border-b border-red-900/50 sticky top-0 z-50 shadow-2xl">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-5">
            <div class="relative w-12 h-12 flex-shrink-0">
                <svg class="spin-slow w-12 h-12" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="47" fill="#1e293b" stroke="#ef4444" stroke-width="3"/>
                    <path d="M3 50 A47 47 0 0 1 97 50 Z" fill="#ef4444"/>
                    <rect x="3" y="47" width="94" height="6" fill="#ef4444"/>
                    <rect x="3" y="47" width="94" height="6" fill="#0f172a"/>
                    <circle cx="50" cy="50" r="13" fill="#0f172a" stroke="#ef4444" stroke-width="3"/>
                    <circle cx="50" cy="50" r="7" fill="#ef4444"/>
                </svg>
            </div>
            <div>
                <h1 class="pixel text-red-500 text-sm sm:text-base leading-tight tracking-wide">POKÉDEX</h1>
                <p class="text-slate-500 text-sm font-medium mt-0.5">
                    {{ $pokemons->count() + $seededPokemons->count() }} {{ ($pokemons->count() + $seededPokemons->count()) === 1 ? 'Pokémon registrado' : 'Pokémon registrados' }}
                </p>
            </div>
        </div>
        <a href="{{ route('pokemon.create') }}"
           class="flex items-center gap-2 bg-red-600 hover:bg-red-500 active:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-red-900/40 transition-all hover:scale-105 active:scale-95 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Novo Pokémon
        </a>
    </div>
</header>

@if(session('success'))
<div class="max-w-7xl mx-auto px-6 mt-5" id="toast">
    <div class="toast flex items-center justify-between bg-green-950 border border-green-700 text-green-400 px-5 py-3.5 rounded-xl shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-green-700/40 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('toast').remove()" class="text-green-600 hover:text-green-300 transition ml-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
@endif

<main class="max-w-7xl mx-auto px-6 py-8 space-y-12">

    @if($seededPokemons->isNotEmpty())
    <section>
        <div class="flex items-center gap-3 mb-5">
            <span class="pixel text-yellow-400 text-xs tracking-widest">★ POKÉMONS INICIAIS</span>
            <div class="flex-1 h-px bg-yellow-900/50"></div>
            <span class="text-xs text-slate-600 font-semibold">Criados para demonstração</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach($seededPokemons as $pokemon)
            @php
                $types    = is_array($pokemon->types)  ? $pokemon->types  : (json_decode($pokemon->types,  true) ?? []);
                $status   = is_array($pokemon->status) ? $pokemon->status : (json_decode($pokemon->status, true) ?? []);
                $firstType = $types[0] ?? 'normal';
                $tColor    = $typeColors[$firstType] ?? $typeColors['normal'];
                $hp        = $status['hp'] ?? 0;
            @endphp
            <div class="card-hover bg-slate-900 border border-yellow-900/40 rounded-2xl overflow-hidden flex flex-col ring-1 ring-yellow-700/20">
                <div class="h-1.5 {{ $tColor['bg'] }}"></div>

                <div class="bg-slate-800/60 relative flex items-center justify-center h-44 p-4 overflow-hidden">
                    <span class="absolute top-2.5 left-3 pixel text-slate-600 text-[8px]">#{{ str_pad($pokemon->id, 3, '0', STR_PAD_LEFT) }}</span>
                    <span class="absolute top-2.5 right-3 pixel text-yellow-500 text-[8px] bg-yellow-900/30 px-2 py-0.5 rounded-full border border-yellow-800/40">INICIAL</span>
                    <div class="absolute inset-0 flex items-center justify-center opacity-5">
                        <svg viewBox="0 0 100 100" class="w-40 h-40"><circle cx="50" cy="50" r="47" fill="white"/><path d="M3 50 A47 47 0 0 1 97 50 Z" fill="white"/><circle cx="50" cy="50" r="13" fill="#0f172a" stroke="white" stroke-width="3"/></svg>
                    </div>
                    @if($pokemon->image_url)
                        <img src="{{ asset($pokemon->image_url) }}" alt="{{ $pokemon->name }}"
                             class="h-36 w-auto object-contain drop-shadow-xl z-10 transition-transform duration-300 hover:scale-110">
                    @else
                        <span class="text-slate-600 text-5xl z-10">?</span>
                    @endif
                </div>

                <div class="p-4 flex flex-col flex-1 gap-3">
                    <h3 class="font-bold text-white text-lg capitalize leading-tight">{{ $pokemon->name }}</h3>

                    <div class="flex flex-wrap gap-1">
                        @foreach($types as $type)
                        @php $tc = $typeColors[$type] ?? $typeColors['normal']; @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold capitalize {{ $tc['bg'] }} {{ $tc['text'] }}">{{ $type }}</span>
                        @endforeach
                    </div>

                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500 font-semibold">HP</span>
                            <span class="text-slate-400 font-bold">{{ $hp }}</span>
                        </div>
                        <div class="h-1.5 bg-slate-700 rounded-full overflow-hidden">
                            <div class="stat-bar h-full rounded-full {{ $statColor($hp) }}" @style("width: " . min(($hp/255)*100, 100) . "%")></div>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-auto pt-1">
                        <a href="{{ route('pokemon.view', $pokemon->id) }}"
                           class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-blue-600/15 text-blue-400 border border-blue-600/20 hover:bg-blue-600/30 transition">
                            Ver
                        </a>
                        <!-- <a href="{{ route('pokemon.edit', $pokemon->id) }}"
                           class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/20 hover:bg-amber-500/30 transition">
                            Editar
                        </a> -->

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <section>
        @if($seededPokemons->isNotEmpty())
        <div class="flex items-center gap-3 mb-5">
            <span class="pixel text-slate-400 text-xs tracking-widest">CADASTRADOS</span>
            <div class="flex-1 h-px bg-slate-800"></div>
        </div>
        @endif

        @if($pokemons->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 gap-6 text-center">
                <svg class="w-24 h-24 text-slate-700 opacity-60" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="47" fill="currentColor" opacity=".3"/>
                    <path d="M3 50 A47 47 0 0 1 97 50 Z" fill="currentColor" opacity=".6"/>
                    <circle cx="50" cy="50" r="13" fill="#0f172a" stroke="currentColor" stroke-width="3"/>
                    <circle cx="50" cy="50" r="7" fill="currentColor"/>
                </svg>
                <p class="pixel text-slate-600 text-xs leading-relaxed">Nenhum Pokémon<br>cadastrado ainda.</p>
                <a href="{{ route('pokemon.create') }}" class="text-red-500 hover:text-red-400 underline underline-offset-4 font-semibold transition">Cadastrar o primeiro →</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @foreach($pokemons as $pokemon)
                @php
                    $types     = is_array($pokemon->types)  ? $pokemon->types  : (json_decode($pokemon->types,  true) ?? []);
                    $status    = is_array($pokemon->status) ? $pokemon->status : (json_decode($pokemon->status, true) ?? []);
                    $firstType = $types[0] ?? 'normal';
                    $tColor    = $typeColors[$firstType] ?? $typeColors['normal'];
                    $hp        = $status['hp'] ?? 0;
                @endphp
                <div class="card-hover bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden flex flex-col">
                    <div class="h-1.5 {{ $tColor['bg'] }}"></div>

                    <div class="bg-slate-800/60 relative flex items-center justify-center h-44 p-4 overflow-hidden">
                        <span class="absolute top-2.5 left-3 pixel text-slate-600 text-[8px]">#{{ str_pad($pokemon->id, 3, '0', STR_PAD_LEFT) }}</span>
                        <div class="absolute inset-0 flex items-center justify-center opacity-5">
                            <svg viewBox="0 0 100 100" class="w-40 h-40"><circle cx="50" cy="50" r="47" fill="white"/><path d="M3 50 A47 47 0 0 1 97 50 Z" fill="white"/><circle cx="50" cy="50" r="13" fill="#0f172a" stroke="white" stroke-width="3"/></svg>
                        </div>
                        @if($pokemon->image_url)
                            <img src="{{ asset($pokemon->image_url) }}" alt="{{ $pokemon->name }}"
                                 class="h-36 w-auto object-contain drop-shadow-xl z-10 transition-transform duration-300 hover:scale-110">
                        @else
                            <span class="text-slate-600 text-5xl z-10">?</span>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1 gap-3">
                        <h3 class="font-bold text-white text-lg capitalize leading-tight">{{ $pokemon->name }}</h3>

                        <div class="flex flex-wrap gap-1">
                            @foreach($types as $type)
                            @php $tc = $typeColors[$type] ?? $typeColors['normal']; @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold capitalize {{ $tc['bg'] }} {{ $tc['text'] }}">{{ $type }}</span>
                            @endforeach
                        </div>

                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-500 font-semibold">HP</span>
                                <span class="text-slate-400 font-bold">{{ $hp }}</span>
                            </div>
                            <div class="h-1.5 bg-slate-700 rounded-full overflow-hidden">
                                <div class="stat-bar h-full rounded-full {{ $statColor($hp) }}" @style("width: " . min(($hp/255)*100, 100) . "%")></div>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-auto pt-1">
                            <a href="{{ route('pokemon.view', $pokemon->id) }}"
                               class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-blue-600/15 text-blue-400 border border-blue-600/20 hover:bg-blue-600/30 transition">
                                Ver
                            </a>
                            <a href="{{ route('pokemon.edit', $pokemon->id) }}"
                               class="flex-1 text-center py-2 text-xs font-bold rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/20 hover:bg-amber-500/30 transition">
                                Editar
                            </a>
                            <form action="{{ route('pokemon.destroy', $pokemon->id) }}" method="POST"
                                  onsubmit="return confirm('Remover {{ addslashes($pokemon->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="py-2 px-3 text-xs font-bold rounded-lg bg-red-600/15 text-red-400 border border-red-600/20 hover:bg-red-600/30 transition">
                                    ✕
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </section>

</main>
</x-layouts.pokedex>
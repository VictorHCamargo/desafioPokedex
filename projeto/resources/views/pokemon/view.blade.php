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
    
    $types = $pokemon->types ?? [];
    $status = $pokemon->status ?? [];
    $firstType = $types[0] ?? 'normal';
    $tColor = $typeColors[$firstType] ?? $typeColors['normal'];
    
    $statLabels = ['hp' => 'HP', 'attack' => 'Attack', 'defense' => 'Defense', 'special_attack' => 'Sp. Atk', 'special_defense' => 'Sp. Def', 'speed' => 'Speed'];
@endphp

<main class="max-w-5xl mx-auto px-6 py-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('pokedex') }}" class="flex items-center gap-2 text-slate-400 hover:text-white transition font-bold text-sm bg-slate-900 px-4 py-2 rounded-lg border border-slate-800">
            ← Voltar
        </a>
        @if(!$pokemon->seeded) {
            <div class="flex gap-3">
                <a href="{{ route('pokemon.edit', $pokemon->id) }}" class="bg-amber-500/20 text-amber-400 hover:bg-amber-500/40 px-4 py-2 rounded-lg font-bold text-sm transition">Editar</a>
                <form action="{{ route('pokemon.destroy', $pokemon->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este Pokémon?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/40 px-4 py-2 rounded-lg font-bold text-sm transition">Deletar</button>
                </form>
            </div>
        }
        @endif
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
        
        <div class="md:w-5/12 relative flex flex-col items-center justify-center p-10 overflow-hidden {{ $tColor['bg'] }} bg-opacity-20">
            <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
                <svg viewBox="0 0 100 100" class="w-96 h-96"><circle cx="50" cy="50" r="47" fill="white"/><path d="M3 50 A47 47 0 0 1 97 50 Z" fill="white"/><circle cx="50" cy="50" r="13" fill="#0f172a" stroke="white" stroke-width="3"/></svg>
            </div>
            
            <div class="w-full flex justify-between items-start z-10 mb-8">
                <span class="px-3 py-1 bg-slate-950/50 text-white rounded-lg font-bold tracking-widest text-sm shadow-inner">
                    #{{ str_pad($pokemon->id, 3, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            @if($pokemon->image_url)
                <img src="{{ asset($pokemon->image_url) }}" alt="{{ $pokemon->name }}" class="w-64 h-64 object-contain drop-shadow-2xl z-10 hover:scale-110 transition-transform duration-500">
            @else
                <div class="w-64 h-64 flex items-center justify-center z-10">
                    <span class="text-slate-600 text-6xl">?</span>
                </div>
            @endif
        </div>

        <div class="md:w-7/12 p-8 md:p-12 flex flex-col justify-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white capitalize tracking-tight mb-4">{{ $pokemon->name }}</h1>
            
            <div class="flex gap-2 mb-8">
                @foreach($types as $type)
                @php $tc = $typeColors[$type] ?? $typeColors['normal']; @endphp
                <span class="px-4 py-1.5 rounded-full text-sm font-bold capitalize shadow-sm {{ $tc['bg'] }} {{ $tc['text'] }}">
                    {{ $type }}
                </span>
                @endforeach
            </div>

            <div class="bg-slate-950/50 rounded-2xl p-6 border border-slate-800">
                <h3 class="text-slate-400 font-bold mb-4 uppercase tracking-widest text-xs">Base Stats</h3>
                <div class="flex flex-col gap-3">
                    @foreach($statLabels as $key => $label)
                    @php 
                        $val = $status[$key] ?? 0; 
                        $percent = min(($val / 255) * 100, 100);
                    @endphp
                    <div class="flex items-center gap-4">
                        <span class="w-20 text-xs font-bold text-slate-300">{{ $label }}</span>
                        <span class="w-8 text-xs font-bold text-white text-right">{{ str_pad($val, 3, '0', STR_PAD_LEFT) }}</span>
                        <div class="flex-1 h-2 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full {{ $statColor($val) }}" @style(['width: ' . $percent . '%'])></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</main>
</x-layouts.pokedex>
@props(['currentTypes' => []])

@php
    $availableTypes = ['normal', 'fire', 'water', 'grass', 'electric', 'ice', 'fighting', 'poison', 'ground', 'flying', 'psychic', 'bug', 'rock', 'ghost', 'dragon', 'dark', 'steel', 'fairy'];
    
    if (!is_array($currentTypes)) {
        $currentTypes = $currentTypes instanceof \Illuminate\Support\Collection 
            ? $currentTypes->toArray() 
            : (array) $currentTypes;
    }
@endphp

<div class="mb-8">
    <label class="block text-slate-400 text-xs font-bold mb-3 uppercase tracking-wider">
        Tipos (Selecione 1 ou 2)
    </label>
    
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
        @foreach($availableTypes as $type)
            @php
                $isChecked = session()->hasOldInput('types')
                    ? (is_array(old('types')) && in_array($type, old('types')))
                    : in_array($type, $currentTypes);

                $errorClasses = ($isChecked && $errors->has('types')) 
                    ? 'border-red-500 ring-1 ring-red-500' 
                    : 'border-slate-700';
            @endphp

            <label class="flex items-center gap-2 bg-slate-800 border {{ $errorClasses }} px-3 py-2
                        rounded-lg cursor-pointer hover:border-slate-500 transition group">
                <input
                    type="checkbox" name="types[]" value="{{ $type }}"
                    class="text-red-500 bg-slate-900 border-slate-700 rounded focus:ring-red-500 cursor-pointer"
                    {{ $isChecked ? 'checked' : '' }}
                >
                <span class="text-sm text-slate-300 capitalize group-hover:text-white transition">
                    {{ $type }}
                </span>
            </label>
        @endforeach
    </div>

    @error('types') 
        <div class="w-full mt-3 px-4 py-2 bg-red-500/10 border border-red-500/50 rounded-lg">
            <span class="text-red-500 text-xs md:text-sm block font-bold tracking-wide italic">
                ⚠ {{ $message }}
            </span>
        </div>
    @enderror
</div>
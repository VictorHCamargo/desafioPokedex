<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $pokemons = [
            [
                'name'      => 'Prudence',                    
                'types'     => json_encode(['psychic','ghost']),    
                'status'    => json_encode([
                    "hp"=> "35", "speed"=> "60", "attack"=> "20", "defense"=> "45", "special_attack"=> "65", "special_defense"=> "80" 
                ]),
                'image_url' => 'img/pokemons_fixos/1778009488.png',                    
                'seeded'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Caution',
                'types'     => json_encode(['ghost','dark']),
                'status'    => json_encode([
                    "hp"=> "55", "speed"=> "90", "attack"=> "45", "defense"=> "55", "special_attack"=> "95", "special_defense"=> "85"
                ]),
                'image_url' => 'img/pokemons_fixos/1778009229.png',
                'seeded'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => 'Scare',
                'types'     => json_encode(['ghost','dark']),
                'status'    => json_encode([
                    "hp"=> "90", "speed"=> "110", "attack"=> "80", "defense"=> "90", "special_attack"=> "135", "special_defense"=> "95"
                ]),
                'image_url' => 'img/pokemons_fixos/1778009877.png',
                'seeded'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
 
        DB::table('pokemons')->insert($pokemons);
    }
}

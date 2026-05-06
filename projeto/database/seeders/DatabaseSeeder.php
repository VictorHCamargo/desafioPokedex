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
        // TODO : completar as informaçoes com os pokemons existente!
         $pokemons = [
            [
                'name'      => '',                    
                'types'     => json_encode(['']),    
                'status'    => json_encode([
                    'hp'              => 0,           
                    'attack'          => 0,           
                    'defense'         => 0,           
                    'special_attack'  => 0,           
                    'special_defense' => 0,          
                    'speed'           => 0,           
                ]),
                'image_url' => '',                    
                'seeded'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => '',
                'types'     => json_encode(['']),
                'status'    => json_encode([
                    'hp'              => 0,
                    'attack'          => 0,
                    'defense'         => 0,
                    'special_attack'  => 0,
                    'special_defense' => 0,
                    'speed'           => 0,
                ]),
                'image_url' => '',
                'seeded'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      => '',
                'types'     => json_encode(['']),
                'status'    => json_encode([
                    'hp'              => 0,
                    'attack'          => 0,
                    'defense'         => 0,
                    'special_attack'  => 0,
                    'special_defense' => 0,
                    'speed'           => 0,
                ]),
                'image_url' => '',
                'seeded'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
 
        DB::table('pokemons')->insert($pokemons);
    }
}

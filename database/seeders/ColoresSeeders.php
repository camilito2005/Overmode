<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colores')->insert([
            ['nombre' => 'Rojo', 'codigo_hex' => '#FF0000', 'created_at' => now()],
            ['nombre' => 'azul/rojo', 'codigo_hex' => '#0000FF #FF0000', 'created_at' => now()],
            ['nombre' => 'Azul', 'codigo_hex' => '#0000FF', 'created_at' => now()],
            ['nombre' => 'Amarillo', 'codigo_hex' => '#FFFF00', 'created_at' => now()],
            ['nombre' => 'negro', 'codigo_hex' => '#000000', 'created_at' => now()],
            ['nombre' => 'Blanco', 'codigo_hex' => '#FFFFFF', 'created_at' => now()],
            ['nombre' => 'Gris', 'codigo_hex' => '#808080', 'created_at' => now()],
            ['nombre' => 'Naranja', 'codigo_hex' => '#FFA500', 'created_at' => now()],
            ['nombre' => 'Rosa', 'codigo_hex' => '#FF0080', 'created_at' => now()],
            ['nombre' => 'Morado', 'codigo_hex' => '#A020F0', 'created_at' => now()],
        ]);
    }
}

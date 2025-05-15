<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Rolseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Administrador del sistema',
                'created_at' => now(),
            ],
            [
                'nombre' => 'Usuario',
                'descripcion' => 'Usuario regular del sistema',
                'created_at' => now(),
            ],
            [
                'nombre' => 'Cliente',
                'descripcion' => 'Moderador de contenido',
                'created_at' => now(),
            ],
        ]);
        //
    }
}

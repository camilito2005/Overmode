<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        //
        DB::table('usuarios')->insert([
            [
                'nombre' => 'Luis',
                'apellido' => 'hernandez',
                'password' => bcrypt('luis12345'),
                'direccion' => 'flower of camp',
                'telefono' => '1234567890',
                'ciudad' => 'Ciudad de Mexico',
                'email' => 'luis@gmail.com',
                'rol_id' => 1,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Jordano',
                'apellido' => 'vinazco',
                'password' => bcrypt('jordano'),
                'direccion' => 'en bayunca',
                'telefono' => '0987654321',
                'ciudad' => 'Ciudad de bayunca',
                'email' => 'jordano@gmail.com',
                'rol_id' => 1,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Camilo el fokin admin',
                'apellido' => 'marrugo barrios',
                'password' => bcrypt('camilo2005'),
                'direccion' => 'la casa de camilo',
                'telefono' => '1122334455',
                'ciudad' => 'Cartagena',
                'email' => 'camilo@gmail',
                'rol_id' => 1,
                'created_at' => now(),
            ],
        ]);

    }
}

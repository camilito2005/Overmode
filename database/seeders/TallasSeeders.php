<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class tallasSedders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tallas')->insert([
            ['nombre' => 'XS', 'created_at' => now()],
            ['nombre' => 'S', 'created_at' => now()],
            ['nombre' => 'M', 'created_at' => now()],
            ['nombre' => 'L', 'created_at' => now()],
            ['nombre' => 'XL', 'created_at' => now()],
            ['nombre' => 'XXL', 'created_at' => now()],
        ]);
    }
}

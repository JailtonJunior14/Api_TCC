<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::create(['nome'=>'São Paulo', 'sigla' => 'SP']);
        Estado::create(['nome'=>'Rio de Janeiro', 'sigla' => 'RJ']);
    }
}

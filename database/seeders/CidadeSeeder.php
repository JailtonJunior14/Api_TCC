<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cidade::create(['nome' => 'São Paulo', 'estado_id' => 1]);
        Cidade::create(['nome' => 'Rio de Janeiro', 'estado_id' => 2]);
    }
}

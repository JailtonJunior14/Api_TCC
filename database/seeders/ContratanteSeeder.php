<?php

namespace Database\Seeders;

use App\Models\Contratante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContratanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contratante::create([
            'nome' => 'teste',
            'email' => 'teste@gmail.com',
            'senha' => Hash::make(1234),
            'id_cidade' => 1,
        ]);
    }
}

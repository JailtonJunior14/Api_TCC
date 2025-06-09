<?php

namespace Database\Seeders;

use App\Models\Prestador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prestador::create([
            'nome' => 'Prestador001',
            'email' => 'prestador001@gmail.com',
            'password' => Hash::make(3698),
            'id_cidade' => 1,
            'id_ramo' => 1
        ]);
    }
}

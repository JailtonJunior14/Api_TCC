<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::create([
            'nome' => 'ADOBE001',
            'email' => 'ADOBE001@gmail.com',
            'password' => Hash::make(102030),
            'id_cidade' => 1,
            'id_ramo' => 2
        ]);
    }
}

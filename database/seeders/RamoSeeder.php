<?php

namespace Database\Seeders;

use App\Models\Ramo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ramos = [
            [
                'nome' => 'Pedreiro',
                'modalidade' => 'presencial'    
            ],

            [
                'nome' => 'web design',
                'modalidade' => 'home-office'
            ],

            [
                'nome' => 'pintor',
                'modalidade' => 'presencial'
            ],

            [
                'nome' => 'editor',
                'modalidade' => 'home-office'
            ]
        ];
        foreach ($ramos as $ramo) {
            Ramo::create($ramo);
        }
        
    }
}

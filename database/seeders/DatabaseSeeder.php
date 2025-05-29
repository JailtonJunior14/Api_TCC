<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PaisSeeder::class,
            EstadoSeeder::class,
            CidadeSeeder::class,
            ContratanteSeeder::class,
            RamoSeeder::class,
            PrestadorSeeder::class,
            EmpresaSeeder::class
        ]);

    }
}

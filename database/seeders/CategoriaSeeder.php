<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ====== TABELA CATEGORIAS ======
            $categorias = [
                ['id' => 1, 'nome' => 'Construção e Reforma'],
                ['id' => 2, 'nome' => 'Instalações e Manutenções'],
                ['id' => 3, 'nome' => 'Limpeza e Conservação'],
                ['id' => 4, 'nome' => 'Jardinagem e Paisagismo'],
                ['id' => 5, 'nome' => 'Decoração e Acabamento'],
                ['id' => 6, 'nome' => 'Serviços Industriais e Técnicos'],
                ['id' => 7, 'nome' => 'Transporte e Logística'],
                ['id' => 8, 'nome' => 'Serviços Domésticos e Pessoais'],
                ['id' => 9, 'nome' => 'Comunicação e Design'],
                ['id' => 10, 'nome' => 'Outros Serviços'],
            ];


            foreach ($categorias as $categoria) {
                Categoria::create($categoria);
            }
    }
}

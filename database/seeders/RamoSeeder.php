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
        // ====== TABELA RAMOS ======
            $ramos = [
                // Construção e Reforma
                ['nome' => 'Pedreiro', 'categoria_id' => 1],
                ['nome' => 'Servente de obra', 'categoria_id' => 1],
                ['nome' => 'Mestre de obras', 'categoria_id' => 1],
                ['nome' => 'Azulejista', 'categoria_id' => 1],
                ['nome' => 'Encanador', 'categoria_id' => 1],
                ['nome' => 'Eletricista', 'categoria_id' => 1],
                ['nome' => 'Pintor', 'categoria_id' => 1],
                ['nome' => 'Gesseiro', 'categoria_id' => 1],
                ['nome' => 'Instalador de drywall', 'categoria_id' => 1],
                ['nome' => 'Marceneiro', 'categoria_id' => 1],
                ['nome' => 'Carpinteiro', 'categoria_id' => 1],
                ['nome' => 'Vidraceiro', 'categoria_id' => 1],
                ['nome' => 'Serralheiro', 'categoria_id' => 1],
                ['nome' => 'Telhadista', 'categoria_id' => 1],
                ['nome' => 'Calheiro', 'categoria_id' => 1],
                ['nome' => 'Instalador de piso laminado', 'categoria_id' => 1],
                ['nome' => 'Impermeabilizador', 'categoria_id' => 1],
                ['nome' => 'Engenheiro civil', 'categoria_id' => 1],
                ['nome' => 'Arquiteto', 'categoria_id' => 1],

                // Instalações e Manutenções
                ['nome' => 'Técnico em refrigeração', 'categoria_id' => 2],
                ['nome' => 'Técnico em eletrônicos', 'categoria_id' => 2],
                ['nome' => 'Técnico em informática', 'categoria_id' => 2],
                ['nome' => 'Instalador de câmeras de segurança', 'categoria_id' => 2],
                ['nome' => 'Instalador de cerca elétrica', 'categoria_id' => 2],
                ['nome' => 'Montador de móveis', 'categoria_id' => 2],
                ['nome' => 'Eletricista automotivo', 'categoria_id' => 2],
                ['nome' => 'Mecânico de autos', 'categoria_id' => 2],
                ['nome' => 'Chaveiro', 'categoria_id' => 2],
                ['nome' => 'Dedetizador', 'categoria_id' => 2],
                ['nome' => 'Bombeiro hidráulico', 'categoria_id' => 2],

                // Limpeza e Conservação
                ['nome' => 'Faxineiro(a) residencial', 'categoria_id' => 3],
                ['nome' => 'Faxineiro(a) comercial', 'categoria_id' => 3],
                ['nome' => 'Diarista', 'categoria_id' => 3],
                ['nome' => 'Lavador de sofás', 'categoria_id' => 3],
                ['nome' => 'Lavador de carpetes', 'categoria_id' => 3],
                ['nome' => 'Jardineiro', 'categoria_id' => 3],
                ['nome' => 'Zelador', 'categoria_id' => 3],
                ['nome' => 'Coletor de entulho', 'categoria_id' => 3],
                ['nome' => 'Limpeza pós-obra', 'categoria_id' => 3],
                ['nome' => 'Limpeza de vidros', 'categoria_id' => 3],

                // Jardinagem e Paisagismo
                ['nome' => 'Paisagista', 'categoria_id' => 4],
                ['nome' => 'Podador de árvores', 'categoria_id' => 4],
                ['nome' => 'Instalador de irrigação', 'categoria_id' => 4],
                ['nome' => 'Manutenção de gramados', 'categoria_id' => 4],

                // Decoração e Acabamento
                ['nome' => 'Decorador de interiores', 'categoria_id' => 5],
                ['nome' => 'Designer de interiores', 'categoria_id' => 5],
                ['nome' => 'Aplicador de papel de parede', 'categoria_id' => 5],
                ['nome' => 'Envernizador', 'categoria_id' => 5],
                ['nome' => 'Montador de móveis planejados', 'categoria_id' => 5],

                // Serviços Industriais e Técnicos
                ['nome' => 'Soldador', 'categoria_id' => 6],
                ['nome' => 'Mecânico industrial', 'categoria_id' => 6],
                ['nome' => 'Técnico em automação', 'categoria_id' => 6],
                ['nome' => 'Técnico em climatização', 'categoria_id' => 6],
                ['nome' => 'Técnico em energia solar', 'categoria_id' => 6],
                ['nome' => 'Técnico em segurança do trabalho', 'categoria_id' => 6],

                // Transporte e Logística
                ['nome' => 'Carreteiro', 'categoria_id' => 7],
                ['nome' => 'Motorista de frete', 'categoria_id' => 7],
                ['nome' => 'Motoboy', 'categoria_id' => 7],
                ['nome' => 'Serviço de mudança residencial', 'categoria_id' => 7],
                ['nome' => 'Entregador autônomo', 'categoria_id' => 7],

                // Serviços Domésticos e Pessoais
                ['nome' => 'Passadeira', 'categoria_id' => 8],
                ['nome' => 'Cozinheira', 'categoria_id' => 8],
                ['nome' => 'Babá', 'categoria_id' => 8],
                ['nome' => 'Cuidador de idosos', 'categoria_id' => 8],
                ['nome' => 'Porteiro', 'categoria_id' => 8],
                ['nome' => 'Caseiro', 'categoria_id' => 8],

                // Comunicação e Design
                ['nome' => 'Designer gráfico', 'categoria_id' => 9],
                ['nome' => 'Fotógrafo', 'categoria_id' => 9],
                ['nome' => 'Videomaker', 'categoria_id' => 9],
                ['nome' => 'Web designer', 'categoria_id' => 9],
                ['nome' => 'Social media', 'categoria_id' => 9],

                // Outros Serviços
                ['nome' => 'Instalador de energia solar', 'categoria_id' => 10],
                ['nome' => 'Instalador de antena', 'categoria_id' => 10],
                ['nome' => 'Instalador de portão eletrônico', 'categoria_id' => 10],
                ['nome' => 'Manutenção de bombas d’água', 'categoria_id' => 10],
                ['nome' => 'Reforma de piscina', 'categoria_id' => 10],
                ['nome' => 'Desentupimento', 'categoria_id' => 10],
            ];


        foreach ($ramos as $ramo) {
            Ramo::create($ramo);
        }
        
    }
}

<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // CONSTRUÇÃO E REFORMA (1)
            ['nome' => 'Leitura e interpretação de projetos', 'id_ramo' => 1],
            ['nome' => 'Medição e nivelamento', 'id_ramo' => 1],
            ['nome' => 'Trabalho com ferramentas manuais e elétricas', 'id_ramo' => 1],
            ['nome' => 'Controle de materiais e planejamento', 'id_ramo' => 1],
            ['nome' => 'Segurança no trabalho (EPI)', 'id_ramo' => 1],
            ['nome' => 'Assentamento de tijolos e blocos', 'id_ramo' => 1],
            ['nome' => 'Reboco e emboço', 'id_ramo' => 1],
            ['nome' => 'Alvenaria estrutural', 'id_ramo' => 1],
            ['nome' => 'Instalação hidráulica', 'id_ramo' => 1],
            ['nome' => 'Instalação elétrica', 'id_ramo' => 1],
            ['nome' => 'Aplicação de massa corrida', 'id_ramo' => 1],
            ['nome' => 'Instalação de pisos e revestimentos', 'id_ramo' => 1],
            ['nome' => 'Montagem de estruturas de gesso', 'id_ramo' => 1],
            ['nome' => 'Execução de telhados', 'id_ramo' => 1],
            ['nome' => 'Marcenaria básica', 'id_ramo' => 1],
            ['nome' => 'Trabalhos com serralheria', 'id_ramo' => 1],
            ['nome' => 'Instalação de portas e janelas', 'id_ramo' => 1],
            ['nome' => 'Impermeabilização', 'id_ramo' => 1],
            ['nome' => 'Montagem de drywall', 'id_ramo' => 1],
        
            // INSTALAÇÕES E MANUTENÇÕES (2)
            ['nome' => 'Diagnóstico técnico', 'id_ramo' => 2],
            ['nome' => 'Uso de multímetro', 'id_ramo' => 2],
            ['nome' => 'Instalação e manutenção preventiva', 'id_ramo' => 2],
            ['nome' => 'Segurança elétrica', 'id_ramo' => 2],
            ['nome' => 'Instalação de ar-condicionado', 'id_ramo' => 2],
            ['nome' => 'Manutenção de refrigeradores', 'id_ramo' => 2],
            ['nome' => 'Reparo de eletrônicos', 'id_ramo' => 2],
            ['nome' => 'Formatação de computadores', 'id_ramo' => 2],
            ['nome' => 'Configuração de redes', 'id_ramo' => 2],
            ['nome' => 'Instalação de câmeras CFTV', 'id_ramo' => 2],
            ['nome' => 'Instalação de cerca elétrica', 'id_ramo' => 2],
            ['nome' => 'Montagem de móveis', 'id_ramo' => 2],
            ['nome' => 'Mecânica automotiva', 'id_ramo' => 2],
            ['nome' => 'Dedetização', 'id_ramo' => 2],
            ['nome' => 'Reparos hidráulicos', 'id_ramo' => 2],
        
            // LIMPEZA E CONSERVAÇÃO (3)
            ['nome' => 'Limpeza residencial', 'id_ramo' => 3],
            ['nome' => 'Limpeza comercial', 'id_ramo' => 3],
            ['nome' => 'Organização de ambientes', 'id_ramo' => 3],
            ['nome' => 'Manuseio de produtos químicos', 'id_ramo' => 3],
            ['nome' => 'Limpeza pós-obra', 'id_ramo' => 3],
            ['nome' => 'Limpeza de vidros', 'id_ramo' => 3],
            ['nome' => 'Lavagem de estofados', 'id_ramo' => 3],
            ['nome' => 'Lavagem de carpetes', 'id_ramo' => 3],
            ['nome' => 'Zeladoria', 'id_ramo' => 3],
            ['nome' => 'Coleta de entulho', 'id_ramo' => 3],
        
            // JARDINAGEM E PAISAGISMO (4)
            ['nome' => 'Cuidado com plantas', 'id_ramo' => 4],
            ['nome' => 'Adubação e fertilização', 'id_ramo' => 4],
            ['nome' => 'Poda de árvores', 'id_ramo' => 4],
            ['nome' => 'Instalação de irrigação', 'id_ramo' => 4],
            ['nome' => 'Manutenção de gramados', 'id_ramo' => 4],
        
            // DECORAÇÃO E ACABAMENTO (5)
            ['nome' => 'Noção de cores e estética', 'id_ramo' => 5],
            ['nome' => 'Aplicação de papel de parede', 'id_ramo' => 5],
            ['nome' => 'Envernizamento', 'id_ramo' => 5],
            ['nome' => 'Montagem de móveis planejados', 'id_ramo' => 5],
            ['nome' => 'Decoração de ambientes', 'id_ramo' => 5],
        
            // SERVIÇOS INDUSTRIAIS E TÉCNICOS (6)
            ['nome' => 'Leitura de normas técnicas', 'id_ramo' => 6],
            ['nome' => 'Operação de máquinas industriais', 'id_ramo' => 6],
            ['nome' => 'Soldagem MIG/MAG/TIG', 'id_ramo' => 6],
            ['nome' => 'Manutenção industrial', 'id_ramo' => 6],
            ['nome' => 'Automação e CLP', 'id_ramo' => 6],
            ['nome' => 'Instalação de climatização', 'id_ramo' => 6],
            ['nome' => 'Instalação de energia solar', 'id_ramo' => 6],
            ['nome' => 'Segurança do trabalho', 'id_ramo' => 6],
        
            // TRANSPORTE E LOGÍSTICA (7)
            ['nome' => 'Direção defensiva', 'id_ramo' => 7],
            ['nome' => 'Organização de cargas', 'id_ramo' => 7],
            ['nome' => 'Gestão de rotas', 'id_ramo' => 7],
            ['nome' => 'Entrega rápida', 'id_ramo' => 7],
            ['nome' => 'Mudança residencial', 'id_ramo' => 7],
        
            // SERVIÇOS DOMÉSTICOS E PESSOAIS (8)
            ['nome' => 'Organização doméstica', 'id_ramo' => 8],
            ['nome' => 'Preparo de refeições', 'id_ramo' => 8],
            ['nome' => 'Passadoria', 'id_ramo' => 8],
            ['nome' => 'Cuidado infantil', 'id_ramo' => 8],
            ['nome' => 'Cuidado de idosos', 'id_ramo' => 8],
            ['nome' => 'Controle de portaria', 'id_ramo' => 8],
            ['nome' => 'Manutenção de áreas externas', 'id_ramo' => 8],
        
            // COMUNICAÇÃO E DESIGN (9)
            ['nome' => 'Criação de artes e logos', 'id_ramo' => 9],
            ['nome' => 'Edição de fotos', 'id_ramo' => 9],
            ['nome' => 'Edição de vídeos', 'id_ramo' => 9],
            ['nome' => 'Criação de sites', 'id_ramo' => 9],
            ['nome' => 'Gestão de redes sociais', 'id_ramo' => 9],
        
            // OUTROS SERVIÇOS (10)
            ['nome' => 'Instalação de antenas', 'id_ramo' => 10],
            ['nome' => 'Instalação de portões eletrônicos', 'id_ramo' => 10],
            ['nome' => 'Manutenção de bombas d\'água', 'id_ramo' => 10],
            ['nome' => 'Reforma de piscinas', 'id_ramo' => 10],
            ['nome' => 'Desentupimento', 'id_ramo' => 10],
        ];
        
        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}

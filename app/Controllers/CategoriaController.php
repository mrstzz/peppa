<?php
// app/Controllers/CategoriaController.php

namespace App\Controllers;

use App\Core\Controller;

class CategoriaController extends Controller {

    public function __construct() {
        // Este endpoint pode ser público, então não precisa de authCheck()
        // Se precisar que o usuário esteja logado, descomente:
        // $this->authCheck();
    }

    /**
     * Busca os detalhes de uma categoria e retorna uma View Parcial (HTML)
     */
    public function detalhes() {
        $categoriaNome = $_GET['categoria'] ?? 'Inválida';

        $dados = [];
        $viewParaRenderizar = '';

        // Lógica para escolher a View e os Dados
        switch ($categoriaNome) {
            
            // --- CASO ESPECÍFICO: SUPERMERCADO ---
            case 'Supermercado':

                $viewParaRenderizar = 'partials/_supermercado_detalhes';
                $dados = $this->getDadosSupermercado($categoriaNome);
                break;

            // --- CASO GENÉRICO (para todas as outras) ---
            default:
                $viewParaRenderizar = 'partials/_categoria_detalhes';
                $dados = $this->getDadosGenericos($categoriaNome);
                break;
        }

        // Renderiza a view parcial escolhida com os dados buscados
        $this->renderPartial($viewParaRenderizar, $dados);
    }


    /**
     * Busca dados específicos para a view de Supermercado
     */
    private function getDadosSupermercado($nome) {

        // LÓGICA REAL: $this->comercianteModel->getDestaquesPorCategoria($nome);
        // LÓGICA REAL: $this->produtoModel->getOfertasPorCategoria($nome);

        // Dados simulados pra teste:
        return [
            'nome' => $nome,
            'descricao' => 'As melhores ofertas da sua região, do hortifruti à padaria, estão aqui. Compare preços e economize!',
            'imagemUrl' => 'https://images.unsplash.com/photo-1608686207856-001b95cf60ca?q=80&w=800&auto=format&fit=crop',
            
            // Sub-categorias
            'subcategorias' => ['Hortifruti', 'Açougue', 'Padaria', 'Bebidas', 'Limpeza', 'Mercearia'],

            // Ofertas em destaque
            'ofertasDestaque' => [
                ['produto' => 'Arroz Tipo 1 (5kg)', 'preco' => 'R$ 21,90', 'comercianteNome' => 'Mercado Central'],
                ['produto' => 'Picanha Bovina (kg)', 'preco' => 'R$ 59,90', 'comercianteNome' => 'Açougue Nobre']
            ],

            // Comerciantes em destaque
            'comerciantesDestaque' => [
                ['nome' => 'Mercado Central', 'bairro' => 'Centro', 'slug' => 'mercado-central', 'logo' => 'https://placehold.co/100x100/EEE/333?text=MC'],
                ['nome' => 'Super Varejão', 'bairro' => 'Vila Nova', 'slug' => 'super-varejao', 'logo' => 'https://placehold.co/100x100/333/EEE?text=SV']
            ]
        ];
    }

    /**
     * Busca dados genéricos (o que você tinha antes)
     */
    private function getDadosGenericos($nome) {
        // Lógica genérica (ex: getDadosCategoria($nome) do exemplo anterior)
        $descricoes = [
            'Drogarias' => 'Farmácias e drogarias com entrega rápida. Medicamentos, cosméticos e produtos de higiene pessoal.',
            'Investimentos' => 'Consulte especialistas em investimentos e faça seu dinheiro render mais com segurança.',
            'Seguros' => 'Proteja o que é importante. Seguros de carro, casa e vida com as melhores corretoras da região.',
            'Consórcios' => 'Planeje seu futuro sem juros. Cartas de consórcio para imóveis, veículos e serviços.',
            'Outros' => 'Uma variedade de outros serviços e produtos locais para atender todas as suas necessidades.'
        ];

        return [
            'nome' => $nome,
            'descricao' => $descricoes[$nome] ?? 'Categoria não encontrada.',
            'imagemUrl' => 'https://placehold.co/800x400/E9752F/white?text=' . urlencode($nome),
            'itens_exemplo' => ['Item A', 'Item B', 'Item C']
        ];
    }


    /**
     * Renderiza uma view parcial (sem o layout principal)
     */
    protected function renderPartial($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . "/../Views/{$view}.php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "<div class='alert alert-danger'>Erro: View parcial [{$view}.php] não encontrada.</div>";
        }
    }
}
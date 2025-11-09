<?php
// app/Views/planos.php

$title = 'Escolha seu Plano';
ob_start();
?>

<!-- Container principal com espaçamento vertical -->
<div class="container mx-auto px-4 py-12 lg:py-16">
    
    <!-- Cabeçalho da página -->
    <header>
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900">Planos de Anúncio</h1>
            <p class="mt-4 text-lg text-gray-600">Escolha o plano que melhor se adapta às suas necessidades e comece a divulgar seu perfil hoje mesmo.</p>
        </div>
    </header>

    <main>
        <!-- Grid responsivo para os planos -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            
            <!-- Plano 1: Básico -->
            <!-- 
                - 'flex flex-col' garante que os cards tenham a mesma altura.
                - 'rounded-lg shadow-lg' é o card básico do Tailwind.
            -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                <!-- Cabeçalho do Card -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-2xl font-semibold text-gray-800">Básico</h4>
                </div>
                
                <!-- Corpo do Card 
                    - 'flex-grow' faz este elemento crescer para preencher o espaço.
                    - 'flex flex-col' permite usar 'mt-auto' no botão.
                -->
                <div class="p-6 flex-grow flex flex-col">
                    <h1 class="text-4xl font-bold text-gray-900">
                        R$750<span class="text-lg font-normal text-gray-500">/anual</span>
                    </h1>
                    <ul class="space-y-3 text-gray-600 mt-6 mb-8">
                        <li>Até 6 fotos na galeria</li>
                        <li>1 video de apresentação</li>
                        <li>Perfil personalizado</li>
                        <li>Acesso a filtros de busca</li>
                        <li>Suporte especializado</li>
                    </ul>
                    
                    <!-- Formulário/Botão 
                        - 'mt-auto' empurra o botão para o final do card.
                    -->
                    <form action="/planos/assinar" method="POST" class="mt-auto">
                        <input type="hidden" name="plano" value="plano_1">
                        <button type="submit" class="w-full text-lg font-semibold py-3 px-6 rounded-lg 
                                                    border-2 border-blue-600 text-blue-600 
                                                    hover:bg-blue-600 hover:text-white transition-colors">
                            Assinar Plano
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Plano 2: Profissional (Destaque) -->
            <!-- 
                - 'relative' para posicionar o "badge".
                - 'border-4 border-blue-600' para o destaque.
            -->
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden flex flex-col relative border-4 border-blue-600">
                <!-- "Badge" de Destaque -->
                <span class="absolute top-0 right-1/2 translate-x-1/2 -translate-y-1/2 bg-blue-600 text-white text-xs font-bold uppercase px-4 py-1 rounded-full">
                    Mais Popular
                </span>

                <!-- Cabeçalho do Card (Cor de Destaque) -->
                <div class="p-6 bg-blue-600 text-white">
                    <h4 class="text-2xl font-semibold">Profissional</h4>
                </div>
                
                <!-- Corpo do Card -->
                <div class="p-6 flex-grow flex flex-col">
                    <h1 class="text-4xl font-bold text-gray-900">
                        R$1289<span class="text-lg font-normal text-gray-500">/anual</span>
                    </h1>
                    <ul class="space-y-3 text-gray-600 mt-6 mb-8">
                        <li>Até 9 fotos na galeria</li>
                        <li>Até 3 vídeos de apresentação</li>
                        <li>Perfil com prioridade média</li>
                        <li>Perfil personalizado</li>
                        <li>Destaque em buscas</li>
                        <li>Suporte especializado</li>
                    </ul>
                    
                    <!-- Formulário/Botão (Cor de Destaque) -->
                    <form action="/planos/assinar" method="POST" class="mt-auto">
                        <input type="hidden" name="plano" value="plano_2">
                        <button type="submit" class="w-full text-lg font-semibold py-3 px-6 rounded-lg 
                                                    bg-blue-600 text-white 
                                                    hover:bg-blue-700 transition-colors">
                            Assinar Plano
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Plano 3: Premium -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                <!-- Cabeçalho do Card -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-2xl font-semibold text-gray-800">Premium</h4>
                </div>
                
                <!-- Corpo do Card -->
                <div class="p-6 flex-grow flex flex-col">
                    <h1 class="text-4xl font-bold text-gray-900">
                        R$1729<span class="text-lg font-normal text-gray-500">/anual</span>
                    </h1>
                    <ul class="space-y-3 text-gray-600 mt-6 mb-8">
                        <li>Até 15 fotos na galeria</li>
                        <li>Até 6 vídeos de apresentação</li>
                        <li>Perfil com prioridade máxima</li>
                        <li>Perfil personalizado</li>
                        <li>Destaque em buscas</li>
                        <li>Gráficos de vendas e pontos de melhorias</li>
                        <li>Suporte prioritário</li>
                    </ul>
                    
                    <!-- Formulário/Botão -->
                    <form action="/planos/assinar" method="POST" class="mt-auto">
                        <input type="hidden" name="plano" value="plano_3">
                        <button type="submit" class="w-full text-lg font-semibold py-3 px-6 rounded-lg 
                                                    border-2 border-blue-600 text-blue-600 
                                                    hover:bg-blue-600 hover:text-white transition-colors">
                            Assinar Plano
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>
<?php
// app/Views/perfil.php

$title = htmlspecialchars($perfil['nome'] ?? 'Perfil');
ob_start();

// Separa as mídias por tipo para facilitar a exibição
$fotoPerfil = 'https://placehold.co/150x150/EFEFEF/333333?text=Perfil';
$galeriaFotos = [];
$galeriaVideos = [];

foreach ($midias as $midia) {
    $caminho = '/uploads/profiles/' . htmlspecialchars($midia['caminho_arquivo']);
    if ($midia['tipo'] === 'perfil') {
        $fotoPerfil = $caminho;
    } elseif ($midia['tipo'] === 'galeria') {
        $galeriaFotos[] = $caminho;
    } elseif ($midia['tipo'] === 'video') {
        $galeriaVideos[] = $caminho;
    }
}
?>

<div class="container mx-auto px-4 my-16 tab-content-container">
    <div class="flex flex-wrap -mx-6">
        
        <div class="w-full lg:w-2/3 px-6 mb-8 lg:mb-0">
            
            <div class="border-b border-gray-200 mb-6">
                <ul class="flex -mb-px" id="perfilTab" role="tablist">
                    <li class="flex-1" role="presentation">
                        <button class="w-full text-center py-4 px-1 border-b-2 border-red-600 text-red-600 font-semibold" 
                                id="fotos-tab" data-tab-target="#fotos" type="button" role="tab" aria-selected="true">
                            Galeria de Fotos
                        </button>
                    </li>
                    <li class="flex-1" role="presentation">
                        <button class="w-full text-center py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium" 
                                id="sobre-tab" data-tab-target="#sobre" type="button" role="tab" aria-selected="false">
                            Sobre Mim
                        </button>
                    </li>
                    <li class="flex-1" role="presentation">
                        <button class="w-full text-center py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium" 
                                id="avaliacoes-tab" data-tab-target="#avaliacoes" type="button" role="tab" aria-selected="false">
                            Avaliações
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="tab-content" id="perfilTabContent">
                <div class_alias="tab-pane" id="fotos" role="tabpanel">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php if (!empty($galeriaFotos)): ?>
                            <?php foreach ($galeriaFotos as $foto): ?>
                            <div class="col">
                                <img src="<?= $foto ?>" class="w-full h-64 object-cover rounded-lg shadow-md" alt="Foto da galeria">
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-500 col-span-full">Nenhuma foto na galeria ainda.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class_alias="tab-pane" id="sobre" role="tabpanel" class="hidden">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="p-6">
                             <div class="prose max-w-none text-gray-700">
                                <p><?= nl2br(htmlspecialchars($perfil['sobre_mim'] ?? 'Informações sobre atendimento, cachês e especialidades ainda não foram adicionadas.')) ?></p>
                             </div>
                        </div>
                    </div>
                </div>
                <div class_alias="tab-pane" id="avaliacoes" role="tabpanel" class="hidden">
                     <p class="text-gray-500">Nenhuma avaliação ainda.</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/3 px-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden sticky top-24">
                <div class="p-6 text-center">
                    <img src="<?= $fotoPerfil ?>" class="rounded-full mb-4 mx-auto object-cover" alt="Foto de Perfil de <?= htmlspecialchars($perfil['nome']) ?>" width="150" height="150">
                    <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($perfil['nome']) ?></h2>
                    <p class="text-gray-500 mb-4"><?= htmlspecialchars($perfil['titulo_perfil'] ?? 'Comerciante em Belo Horizonte') ?></p>
                    <hr class="my-4 border-gray-200">
                    <p class="text-left text-gray-600 text-sm"><?= nl2br(htmlspecialchars($perfil['descricao_perfil'] ?? 'Descrição não informada.')) ?></p>
                    
                    <div class="flex flex-col gap-3 mt-6">
                        <a href="#" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg text-lg transition-colors">
                            <i class="bi bi-whatsapp mr-2"></i>Chamar no WhatsApp
                        </a>
                        <a href="#" class="flex items-center justify-center border border-gray-300 text-gray-700 hover:bg-gray-100 font-semibold py-3 px-4 rounded-lg transition-colors">
                            <i class="bi bi-telephone mr-2"></i>Ver Telefone
                        </a>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-between text-sm">
                    <small class="text-gray-500">ID do Perfil: #<?= htmlspecialchars($perfil['comerc_id']) ?></small>
                    <a href="#" class="text-red-500 hover:underline font-medium">Denunciar</a>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden mt-6">
                <div class="p-4 border-b">
                    <h5 class="text-lg font-semibold text-gray-800">Características</h5>
                </div>
                <div class="p-4">
                    <?php 
                        $filtros = !empty($perfil['filtros']) ? json_decode($perfil['filtros'], true) : [];
                    ?>
                    <?php if (!empty($filtros)): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach($filtros as $filtro): ?>
                                <span class="inline-block bg-red-100 text-red-800 text-sm font-semibold px-3 py-1 rounded-full"><?= htmlspecialchars($filtro) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">Nenhuma característica informada.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tab-content-container [role="tab"]');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = button.getAttribute('data-tab-target');
            const targetPanel = document.querySelector(targetId);
            
            // Container pai
            const container = button.closest('.tab-content-container');
            
            // Desativa todos os botões
            container.querySelectorAll('[role="tab"]').forEach(btn => {
                btn.setAttribute('aria-selected', 'false');
                btn.classList.remove('text-red-600', 'border-red-600');
                btn.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
            });
            
            // Esconde todos os painéis
            container.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                panel.classList.add('hidden');
            });
            
            // Ativa o botão clicado e seu painel
            button.setAttribute('aria-selected', 'true');
            button.classList.add('text-red-600', 'border-red-600');
            button.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
            
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>
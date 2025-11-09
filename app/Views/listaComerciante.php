<?php
// app/Views/Comerciante.php

$title = 'Comerciantes';
ob_start();
?>

<div class="container mx-auto px-4 my-16 tab-content-container">
    <div class="border-b border-gray-200 mb-6">
        <ul class="flex -mb-px" id="categoryTab" role="tablist">
            <li class="flex-1" role="presentation">
                <button class="w-full text-center py-4 px-1 border-b-2 border-red-600 text-red-600 font-semibold" 
                        id="comerciantes-tab" data-tab-target="#comerciantes" type="button" role="tab" aria-selected="true">
                    Comerciantes
                </button>
            </li>
            <li class="flex-1" role="presentation">
                <button class="w-full text-center py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium" 
                        id="homens-tab" data-tab-target="#homens" type="button" role="tab" aria-selected="false">
                    Homens (Exemplo)
                </button>
            </li>
            <li class="flex-1" role="presentation">
                <button class="w-full text-center py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium" 
                        id="trans-tab" data-tab-target="#trans" type="button" role="tab" aria-selected="false">
                    Trans (Exemplo)
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="categoryTabContent">
        <div class_alias="tab-pane" id="comerciantes" role="tabpanel">
            
            <h2 class="text-2xl font-semibold mb-5 text-gray-800">Encontre comerciantes em Belo Horizonte, MG</h2>

            <div class="flex flex-wrap gap-2 mb-6">
                <button class="text-sm border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-1 px-4 rounded-full transition-colors">Supermercados</button>
                <button class="text-sm border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-1 px-4 rounded-full transition-colors">Drogarias</button>
                <button class="text-sm border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-1 px-4 rounded-full transition-colors">Sorveterias</button>
                <button class="text-sm border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-1 px-4 rounded-full transition-colors">Restaurantes</button>
                <button class="text-sm border border-gray-400 text-gray-700 hover:bg-gray-100 font-semibold py-1 px-4 rounded-full transition-colors">Melhores Avaliados</button>
            </div>

            <div class="flex justify-between items-center mb-6 border-t border-b border-gray-200 py-3">
                <div>
                    <a href="#" class="font-semibold text-gray-800 hover:text-red-600 transition-colors">
                        Ordenar por <i class="bi bi-chevron-down text-xs"></i>
                    </a>
                </div>
                <div>
                    <a href="#" class="font-semibold text-gray-800 hover:text-red-600 transition-colors">
                        Filtrar <i class="bi bi-funnel"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (!empty($comerciantes)): ?>
                <?php foreach ($comerciantes as $comerciante): ?>
                <div class="col">
                    <div class="h-full bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
                        <?php
                            $imgPath = !empty($comerciante['caminho_arquivo']) 
                                ? "/uploads/profiles/" . htmlspecialchars($comerciante['caminho_arquivo']) 
                                : "https://placehold.co/300x400/EFEFEF/333333?text=Sem+Foto";
                        ?>
                        <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($comerciante['nome']) ?>" class="w-full h-96 object-cover">
                        <div class="p-4 text-center">
                            <h5 class="text-lg font-semibold text-gray-800 mb-1"><?= htmlspecialchars($comerciante['nome']) ?></h5>
                            <p class="text-gray-500 text-sm mb-3">Bairro, Cidade</p>
                            <a href="/perfil/<?= htmlspecialchars($comerciante['id'] ?? '') ?>" class="w-full block text-center border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-2 px-4 rounded-lg transition-colors" target="_blank">Ver Perfil</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full">
                    <p class="text-center text-gray-500 py-10">Nenhum perfil de comerciante encontrado no momento.</p>
                </div>
            <?php endif; ?>
        </div>

        </div>
        
        <div class_alias="tab-pane" id="homens" role="tabpanel" class="hidden">
            <p class="text-center p-10 text-gray-500">Conteúdo para Homens em breve.</p>
        </div>
        <div class_alias="tab-pane" id="trans" role="tabpanel" class="hidden">
            <p class="text-center p-10 text-gray-500">Conteúdo para Trans em breve.</p>
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
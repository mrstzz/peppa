<?php
// app/Views/home.php

$title = 'Página Inicial';

ob_start();
?>

<!-- Estilo para ocultar a barra de rolagem do carrossel -->
<style>
    #servicos-carousel-container {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
    }
    #servicos-carousel-container::-webkit-scrollbar { 
        display: none;  /* Safari e Chrome */
    }
</style>

<!-- Hero Section -->
<div class="relative text-white" style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2069&auto=format&fit=crop'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black/60"></div> <!-- Overlay escuro -->

    <script src="js/ajaxSuporte.js"></script>
    <script src="js/ajaxCategoria.js"></script>

    <div class="relative container mx-auto px-4 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto flex items-center">
            <div class="w-full lg:w-7/12 text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">Quem conhece o comércio local sabe: crescer é mais fácil com a gente.</h1>
                <p class="text-lg lg:text-xl opacity-90 mb-6">
                    Conectamos você aos melhores comerciantes da região. Simples, rápido e eficiente.
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 mt-4">
                    <a href="/info-comerciante" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">Anunciar como comerciante</a>
                    <a href="/register?type=usuario" class="bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">Cadastrar como cliente</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seção de Serviços com Carrossel -->
<div class="container mx-auto px-4 my-16">
    <h2 class="text-center text-3xl font-bold mb-8 text-gray-800">Produtos e Serviços</h2>
    
    <?php 
    $servicos = [
        'Supermercado', 'Drogarias', 'Investimentos', 'Seguros', 
        'Consórcios', 'Outros', 'Serviço 7', 'Serviço 8', 'Serviço 9'
    ];
    ?>

    <!-- Wrapper do Carrossel -->
    <div class="relative max-w-7xl mx-auto">

        <!-- Container que faz o scroll -->
        <div id="servicos-carousel-container" class="overflow-x-auto scroll-smooth flex gap-6 py-4">
            
            <?php foreach ($servicos as $servico): ?>
                
                <!-- Card de Serviço -->
                <!-- 
                  Largura definida para o scroll funcionar corretamente.
                  'w-[90%]' em telas pequenas, 'w-1/3' em telas grandes.
                  'flex-shrink-0' impede que os cards sejam espremidos.
                -->
                <div class="flex-shrink-0 w-[90%] sm:w-1/2 lg:w-1/3 
                            relative overflow-hidden rounded-xl shadow-lg 
                            transition-all duration-300 ease-in-out 
                            hover:-translate-y-1 hover:shadow-2xl 
                            cursor-pointer card-categoria-trigger"
                     data-modal-toggle="modalCategoria" 
                     data-categoria="<?= htmlspecialchars($servico) ?>">
                    
                    <img src="https://placehold.co/400x300/f03325/white?text=<?= urlencode($servico) ?>" 
                         alt="Ícone do serviço <?= $servico ?>" 
                         class="w-full h-48 object-cover">
                    
                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent">
                        <p class="text-white text-lg font-semibold mb-0"><?= $servico ?></p>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
        
        <!-- Controles do Carrossel (Anterior) -->
        <button id="carousel-prev" 
                class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-4 
                       bg-white hover:bg-gray-100 rounded-full p-0 w-12 h-12 
                       shadow-lg z-10 transition-all flex items-center justify-center
                       disabled:opacity-30 disabled:cursor-not-allowed">
            <i class="bi bi-chevron-left text-red-600 text-2xl"></i>
        </button>
        
        <!-- Controles do Carrossel (Próximo) -->
        <button id="carousel-next" 
                class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-4 
                       bg-white hover:bg-gray-100 rounded-full p-0 w-12 h-12 
                       shadow-lg z-10 transition-all flex items-center justify-center
                       disabled:opacity-30 disabled:cursor-not-allowed">
            <i class="bi bi-chevron-right text-red-600 text-2xl"></i>
        </button>
    </div>
</div>


<!-- Seção "Fale Conosco" (Sem alteração) -->
<div class="container mx-auto px-4 my-16">
    <div class="bg-white p-6 md:p-8 rounded-lg border border-gray-200 shadow-sm flex flex-col md:flex-row items-center gap-6">
        <div class="flex-shrink-0 text-red-600">
             <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
            </svg>
        </div>
        <div class="flex-grow text-center md:text-left">
            <h3 class="text-2xl font-bold text-gray-800">Alguma dúvida? Te ajudamos!</h3>
            <p class="text-lg text-gray-600 mt-2">Acesse nossa Central de Relacionamento e fale conosco. Estamos prontos para te atender e tirar todas as suas dúvidas.</p>
        </div>
        <div class="flex-shrink-0 mt-4 md:mt-0">
            <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors" 
               data-modal-toggle="modalContato">
                Fale Conosco
            </a>
        </div>
    </div>
</div>

<!-- Modal Categoria (Estilo Tailwind) -->
<div id="modalCategoria" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modalCategoriaLabel" role="dialog" aria-modal="true">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-3xl w-full m-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h5 class="text-xl font-semibold text-gray-800" id="modalCategoriaLabel">Carregando...</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" data-modal-hide="modalCategoria" aria-label="Close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6" id="modalCategoriaBody">
            <div class="flex flex-col items-center justify-center p-4 min-h-[200px]">
                <div class="w-12 h-12 border-4 border-red-500 border-t-transparent rounded-full animate-spin" role="status"></div>
                <p class="mt-3 text-gray-600">Buscando informações...</p>
            </div>
        </div>
        <div class="p-4 bg-gray-50 border-t text-right">
            <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors" data-modal-hide="modalCategoria">Fechar</button>
        </div>
    </div>
</div>

<!-- Modal Contato (Estilo Tailwind) -->
<div id="modalContato" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden" aria-labelledby="modalContatoLabel" role="dialog" aria-modal="true">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-lg w-full m-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h5 class="text-xl font-semibold text-gray-800" id="modalContatoLabel">Enviar Mensagem ao Suporte</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" data-modal-hide="modalContato" aria-label="Close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6">
            <div id="contatoFeedback" class="p-4 rounded-md mb-4 hidden" role="alert"></div>
            <form id="formContatoAjax">
                <div class="mb-4">
                    <label for="assunto" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="assunto" name="assunto" required>
                </div>
                <div class="mb-4">
                    <label for="mensagem" class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="mensagem" name="mensagem" rows="5" required></textarea>
                </div>
            </form>
        </div>
        <div class="p-4 bg-gray-50 border-t flex justify-end gap-3">
            <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors" data-modal-hide="modalContato">Fechar</button>
            <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors" id="btnEnviarContato">Enviar</button>
        </div>
    </div>
</div>


<!-- 
============================================================
   SCRIPT PARA CARROSSEL E MODAIS
============================================================
-->
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // --- LÓGICA DO CARROSSEL ---
    const container = document.getElementById('servicos-carousel-container');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');

    if (container && prevBtn && nextBtn) {
        
        // Função para pegar a distância de scroll (largura do card + gap)
        const getScrollAmount = () => {
            const firstCard = container.querySelector('.card-categoria-trigger');
            if (!firstCard) return 300; // Valor fallback
            const gap = parseFloat(window.getComputedStyle(container).gap) || 24; // 24px = gap-6
            return firstCard.offsetWidth + gap;
        };

        // Função para checar os limites do scroll e desabilitar botões
        const checkScrollLimits = () => {
            if (!container) return;
            const maxScroll = container.scrollWidth - container.clientWidth;
            prevBtn.disabled = container.scrollLeft <= 0;
            nextBtn.disabled = container.scrollLeft >= maxScroll - 5; // -5px de margem de erro
        };

        // Event Listeners dos botões
        nextBtn.addEventListener('click', () => {
            container.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            container.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        // Checa os limites no carregamento e ao rolar
        container.addEventListener('scroll', checkScrollLimits);
        checkScrollLimits(); // Checa no carregamento inicial
    }

    // --- LÓGICA DOS MODAIS ---
    
    // Função para abrir modal
    const openModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            // Simula o evento 'show.bs.modal' para seu ajaxCategoria.js
            if (modalId === 'modalCategoria' && window.event) {
                const triggerElement = window.event.target.closest('[data-modal-toggle]');
                const event = new CustomEvent('show.bs.modal', { 
                    detail: { relatedTarget: triggerElement }
                });
                modal.dispatchEvent(event);
            }
        }
    };

    // Função para fechar modal
    const closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    // Gatilho para abrir modal
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = button.getAttribute('data-modal-toggle');
            openModal(modalId);
        });
    });

    // Gatilho para fechar modal (botões de fechar)
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = button.getAttribute('data-modal-hide');
            closeModal(modalId);
        });
    });

    // Gatilho para fechar modal (clicando no fundo)
    document.querySelectorAll('[id^="modal"]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) { // Se o clique foi no próprio elemento de fundo
                closeModal(modal.id);
            }
        });
    });
});
</script>

<?php
// Pega todo o conteúdo do buffer e armazena na variável $content
$content = ob_get_clean();

// Inclui o arquivo de layout principal
require __DIR__ . '/layouts/app.php';
?>
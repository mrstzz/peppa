document.addEventListener('DOMContentLoaded', function () {
    const modalCategoria = document.getElementById('modalCategoria');
    
    // Verifica se o modal existe nesta página
    if (modalCategoria) {
        
        // Ouve o evento 'show.bs.modal' (que é simulado pelo home.php)
        modalCategoria.addEventListener('show.bs.modal', function (event) {
            
            // MUDANÇA 1: O "card" agora vem de event.detail.relatedTarget
            // (porque é um CustomEvent vindo do script do home.php)
            const card = event.detail.relatedTarget;

            // Verificação de segurança
            if (!card) {
                console.error('O elemento que disparou o modal (relatedTarget) não foi encontrado no evento.');
                return;
            }
            
            const categoriaNome = card.dataset.categoria;

            const modalTitle = document.getElementById('modalCategoriaLabel');
            const modalBody = document.getElementById('modalCategoriaBody');

            // Define o título
            modalTitle.textContent = categoriaNome;
            
            // MUDANÇA 2: HTML do spinner atualizado para classes Tailwind
            modalBody.innerHTML = `
                <div class="flex flex-col items-center justify-center p-4 min-h-[200px]">
                    <div class="w-12 h-12 border-4 border-red-500 border-t-transparent rounded-full animate-spin" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3 text-gray-600">Buscando informações...</p>
                </div>`;

            // Faz a requisição AJAX (lógica fetch mantida, está ótima)
            fetch('/categoria/detalhes?categoria=' + encodeURIComponent(categoriaNome))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro de rede: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(htmlContent => {
                    // Carrega o HTML recebido
                    modalBody.innerHTML = htmlContent;
                })
                .catch(error => {
                    console.error('Erro ao buscar detalhes da categoria:', error);
                    
                    // MUDANÇA 3: HTML do alerta de erro atualizado para classes Tailwind
                    modalBody.innerHTML = `
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Não foi possível carregar os detalhes.</span>
                            <p>Por favor, tente novamente mais tarde.</p>
                        </div>`;
                });
        });
    }
});
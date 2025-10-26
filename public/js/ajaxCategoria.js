document.addEventListener('DOMContentLoaded', function () {
    const modalCategoria = document.getElementById('modalCategoria');
    
    // Verifica se o modal existe nesta página
    if (modalCategoria) {
        
        modalCategoria.addEventListener('show.bs.modal', function (event) {
            
            const card = event.relatedTarget;
            
            const categoriaNome = card.dataset.categoria;

            const modalTitle = document.getElementById('modalCategoriaLabel');
            const modalBody = document.getElementById('modalCategoriaBody');

            modalTitle.textContent = categoriaNome;
            modalBody.innerHTML = `
                <div class="text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Buscando informações...</p>
                </div>`;

            // Faz a requisição AJAX para buscar o HTML
            fetch('/categoria/detalhes?categoria=' + encodeURIComponent(categoriaNome))
                .then(response => {
                    if (!response.ok) {
                        // Se a resposta da rede não for OK (ex: 404, 500)
                        throw new Error('Erro de rede: ' + response.statusText);
                    }
                    // Esperamos uma resposta de TEXTO (HTML), não JSON
                    return response.text();
                })
                .then(htmlContent => {
                    modalBody.innerHTML = htmlContent;
                })
                .catch(error => {
                    console.error('Erro ao buscar detalhes da categoria:', error);
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <strong>Oops!</strong> Não foi possível carregar os detalhes.
                            Por favor, tente novamente mais tarde.
                        </div>`;
                });
        });
    }
});
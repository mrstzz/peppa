<?php
// app/Views/home.php

$title = 'Página Inicial';

ob_start();
?>

<style>
    .hero-section {
        background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2069&auto=format&fit=crop'); 
        background-size: cover;
        background-position: center;
        color: white;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7); /* Sombra no texto para melhor leitura */
    }

    .service-card {
        border: none;
        border-radius: 0.75rem; 
        overflow: hidden; 
        position: relative; 
        transition: transform 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-5px); 
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .service-card img {
        width: 100%;
        height: 150px;
        object-fit: cover; 
    }

    .service-card .card-title-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent); 
        padding: 1rem;
        color: white;
        font-weight: 600;
    }
</style>

<div class="hero-section py-5">
    <script src="js/ajaxSuporte.js"></script>
    <script src="js/ajaxCategoria.js"></script>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-7 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">Quem conhece o comércio local sabe: crescer é mais fácil com a gente.</h1>
                <p class="col-lg-10 fs-4">
                    Conectamos você aos melhores comerciantes da região. Simples, rápido e eficiente.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                    <a href="/info-comerciante" class="btn btn-danger btn-lg px-4 me-md-2 fw-bold">Anunciar como comerciante</a>
                    <a href="/register?type=usuario" class="btn btn-outline-light btn-lg px-4">Cadastrar como cliente</a>
                </div>
            </div>
            </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center fw-bold mb-4">Produtos e Serviços</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 text-center">
        
        <?php 
        $servicos = ['Supermercado', 'Drogarias', 'Investimentos', 'Seguros', 'Consórcios', 'Outros'];
        foreach ($servicos as $servico): 
        ?>
        <div class="col">
            <div class="card service-card card-categoria-trigger" 
                 data-bs-toggle="modal" 
                 data-bs-target="#modalCategoria" 
                 data-categoria="<?= htmlspecialchars($servico) ?>"
                 style="cursor: pointer;">

                <img src="https://placehold.co/400x300/E9752F/white?text=<?= urlencode($servico) ?>" alt="Ícone do serviço <?= $servico ?>">
                <div class="card-title-overlay">
                    <p class="mb-0"><?= $servico ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoriaLabel">Carregando...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalCategoriaBody">
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Buscando informações...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row bg-light p-3 align-items-center mt-5 rounded-3 border">
        <div class="col-md-2 text-center">
             <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
            </svg>
        </div>
        <div class="col-md-9">
        <h3 class="fw-bold">Alguma dúvida? Te ajudamos!</h3>
        <p class="lead">Acesse nossa Central de Relacionamento e fale conosco. Estamos prontos para te atender e tirar todas as suas dúvidas.</p>
        
        <a href="#" class="btn btn-danger fw-bold" data-bs-toggle="modal" data-bs-target="#modalContato">
            Fale Conosco
        </a>
    </div>

    <div class="modal fade" id="modalContato" tabindex="-1" aria-labelledby="modalContatoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalContatoLabel">Enviar Mensagem ao Suporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contatoFeedback" class="alert" style="display:none;"></div>
                    
                    <form id="formContatoAjax">
                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto</label>
                            <input type="text" class="form-control" id="assunto" name="assunto" required>
                        </div>
                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Mensagem</label>
                            <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btnEnviarContato">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


<?php
// Pega todo o conteúdo do buffer (o HTML acima) e o armazena na variável $content (variável preservada)
$content = ob_get_clean();

// Inclui o arquivo de layout principal, que usará $title e $content. (Estrutura preservada)
require __DIR__ . '/layouts/app.php';
?>
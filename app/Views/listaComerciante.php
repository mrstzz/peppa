<?php
// app/Views/Comerciante.php

$title = 'Comerciantes';
ob_start();
?>

<div class="container my-5">
    <!-- Abas de Categoria -->
    <ul class="nav nav-tabs nav-fill mb-4" id="categoryTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="comerciantes-tab" data-bs-toggle="tab" data-bs-target="#comerciantes" type="button" role="tab" aria-controls="comerciantes" aria-selected="true">Comerciantes</button>
        </li>
    </ul>

    <!-- Conteúdo das Abas -->
    <div class="tab-content" id="categoryTabContent">
        <div class="tab-pane fade show active" id="comerciantes" role="tabpanel" aria-labelledby="comerciantes-tab">
            
            <h2 class="mb-4">Encontre comerciantes em Belo Horizonte, MG</h2>

            <!-- Filtros Rápidos -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <button class="btn btn-outline-danger btn-sm">Supermercados</button>
                <button class="btn btn-outline-danger btn-sm">Drogarias</button>
                <button class="btn btn-outline-danger btn-sm">Sorveterias</button>
                <button class="btn btn-outline-danger btn-sm">Restaurantes</button>
                <button class="btn btn-outline-danger btn-sm">Melhores Avaliados</button>
            </div>

            <!-- Ordenar e Filtrar -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="#" class="text-decoration-none text-dark fw-bold">Ordenar por <i class="bi bi-chevron-down"></i></a>
                </div>
                <div>
                    <a href="#" class="text-decoration-none text-dark fw-bold">Filtrar <i class="bi bi-funnel"></i></a>
                </div>
            </div>

            <!-- Grid de Perfis -->
           <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if (!empty($comerciantes)): ?>
                <?php foreach ($comerciantes as $comerciante): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <?php
                            // Define o caminho da imagem. Usa o placeholder se não houver foto.
                            $imgPath = !empty($comerciante['caminho_arquivo']) 
                                ? "/uploads/profiles/" . htmlspecialchars($comerciante['caminho_arquivo']) 
                                : "https://placehold.co/300x400/EFEFEF/333333?text=Sem+Foto";
                        ?>
                        <img src="<?= $imgPath ?>" class="card-img-top" alt="<?= htmlspecialchars($comerciante['nome']) ?>" style="height: 400px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($comerciante['nome']) ?></h5>
                            <p class="card-text text-muted">Bairro, Cidade</p>
                            <a href="/perfil/<?= htmlspecialchars($comerciante['id'] ?? '') ?>" class="btn btn-outline-primary w-100 mb-2" target="_blank">Ver Perfil</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Nenhum perfil de comerciante encontrado no momento.</p>
                </div>
            <?php endif; ?>
        </div>

        </div>
        <div class="tab-pane fade" id="homens" role="tabpanel" aria-labelledby="homens-tab">
            <p class="text-center p-5">Conteúdo para Homens em breve.</p>
        </div>
        <div class="tab-pane fade" id="trans" role="tabpanel" aria-labelledby="trans-tab">
            <p class="text-center p-5">Conteúdo para Trans em breve.</p>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>

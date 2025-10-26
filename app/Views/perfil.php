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

<div class="container my-5">
    <div class="row g-5">
        <!-- Coluna Principal (Esquerda) com Abas -->
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill mb-4" id="perfilTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="fotos-tab" data-bs-toggle="tab" data-bs-target="#fotos" type="button" role="tab">Galeria de Fotos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sobre-tab" data-bs-toggle="tab" data-bs-target="#sobre" type="button" role="tab">Sobre Mim</button>
                </li>
                 <li class="nav-item" role="presentation">
                    <button class="nav-link" id="avaliacoes-tab" data-bs-toggle="tab" data-bs-target="#avaliacoes" type="button" role="tab">Avaliações</button>
                </li>
            </ul>
            <div class="tab-content" id="perfilTabContent">
                <!-- Aba da Galeria de Fotos -->
                <div class="tab-pane fade show active" id="fotos" role="tabpanel">
                    <div class="row row-cols-2 row-cols-md-3 g-3">
                        <?php if (!empty($galeriaFotos)): ?>
                            <?php foreach ($galeriaFotos as $foto): ?>
                            <div class="col">
                                <img src="<?= $foto ?>" class="img-fluid rounded shadow-sm" alt="Foto da galeria" style="width: 100%; height: 250px; object-fit: cover;">
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Nenhuma foto na galeria ainda.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Aba Sobre Mim -->
                <div class="tab-pane fade" id="sobre" role="tabpanel">
                    <div class="card shadow-sm">
                        <div class="card-body">
                             <p><?= nl2br(htmlspecialchars($perfil['sobre_mim'] ?? 'Informações sobre atendimento, cachês e especialidades ainda não foram adicionadas.')) ?></p>
                        </div>
                    </div>
                </div>
                <!-- Aba Avaliações -->
                <div class="tab-pane fade" id="avaliacoes" role="tabpanel">
                     <p class="text-muted">Nenhuma avaliação ainda.</p>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral (Direita) -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 2rem;">
                <div class="card-body text-center">
                    <img src="<?= $fotoPerfil ?>" class="rounded-circle mb-3" alt="Foto de Perfil de <?= htmlspecialchars($perfil['nome']) ?>" width="150" height="150" style="object-fit: cover;">
                    <h2 class="card-title h3"><?= htmlspecialchars($perfil['nome']) ?></h2>
                    <p class="text-muted"><?= htmlspecialchars($perfil['titulo_perfil'] ?? 'Comerciante em Belo Horizonte') ?></p>
                    <hr>
                    <p class="text-start"><?= nl2br(htmlspecialchars($perfil['descricao_perfil'] ?? 'Descrição não informada.')) ?></p>
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="#" class="btn btn-success btn-lg"><i class="bi bi-whatsapp me-2"></i>Chamar no WhatsApp</a>
                        <a href="#" class="btn btn-outline-secondary"><i class="bi bi-telephone me-2"></i>Ver Telefone</a>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <small class="text-muted">ID do Perfil: #<?= htmlspecialchars($perfil['comerc_id']) ?></small>
                    <a href="#">Denunciar</a>
                </div>
            </div>

            <!-- Filtros/Tags -->
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Características</h5>
                </div>
                <div class="card-body">
                    <?php 
                        $filtros = !empty($perfil['filtros']) ? json_decode($perfil['filtros'], true) : [];
                    ?>
                    <?php if (!empty($filtros)): ?>
                        <?php foreach($filtros as $filtro): ?>
                            <span class="badge bg-danger me-1 mb-1"><?= htmlspecialchars($filtro) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Nenhuma característica informada.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>

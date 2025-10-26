<?php
// app/Views/dashboardComerciante.php

$title = 'Meu Dashboard';
print_r($comerc);
ob_start();
?>

<div class="container my-5">
    <div class="row">
        <!-- Coluna de Navegação/Resumo -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <?php
                        // Define o caminho da foto de perfil. Usa placeholder se não houver.
                        $profilePic = !empty($comerc['foto_perfil'])
                            ? "/uploads/profiles/" . htmlspecialchars($comerc['foto_perfil'])
                            : "https://placehold.co/150x150/EFEFEF/333333?text=Perfil";
                    ?>
                    <img src="<?= $profilePic ?>" class="rounded-circle mb-3" alt="Foto de Perfil" width="150" height="150" style="object-fit: cover;">
                    <h4 class="card-title"><?= htmlspecialchars($comerc['nome'] ?? 'Nome Indefinido') ?></h4>
                    <p class="text-muted">ID do Perfil: #<?= htmlspecialchars($comerc['id'] ?? 'N/A') ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Status do Perfil
                        <?php 
                            $status = htmlspecialchars($comerc['status'] ?? 'indefinido');
                            $badge_class = 'bg-secondary';
                            if ($status === 'ativo') $badge_class = 'bg-success';
                            if ($status === 'provisorio') $badge_class = 'bg-warning text-dark';
                            if ($status === 'suspenso') $badge_class = 'bg-danger';
                        ?>
                        <span class="badge <?= $badge_class ?> rounded-pill"><?= ucfirst($status) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Plano Contratado
                        <span class="fw-bold text-primary"><?= ucfirst(str_replace('_', ' ', $comerc['plano'] ?? 'Nenhum')) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Expira em
                        <span><?= !empty($comerc['plano_expira_em']) ? date('d/m/Y', strtotime($comerc['plano_expira_em'])) : '-' ?></span>
                    </li>
                </ul>
                <div class="card-body">
                    <a href="/perfil/<?= htmlspecialchars($comerc['id'] ?? '') ?>" class="btn btn-outline-primary w-100 mb-2" target="_blank">Ver Meu Perfil Público</a>
                    <a href="/logout" class="btn btn-outline-danger w-100">Sair da Conta</a>
                </div>
            </div>
        </div>

        <!-- Coluna de Ações -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Gerenciamento do Perfil</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Complete seu perfil para atrair mais clientes</h5>
                    <p class="card-text">Mantenha suas informações, fotos e vídeos sempre atualizados para ter mais destaque na plataforma.</p>
                    <div class="list-group">
                        <a href="/perfil/editar" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-person-lines-fill fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold">Editar Informações do Perfil</div>
                                <small class="text-muted">Atualize sua descrição, tópicos e filtros.</small>
                            </div>
                        </a>
                        <a href="/galeria/gerenciar" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-images fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold">Gerenciar Galeria de Fotos e Vídeos</div>
                                <small class="text-muted">Faça upload, defina sua foto de capa e organize sua mídia.</small>
                            </div>
                        </a>
                        <a href="/planos" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-gem fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold">Meus Planos e Assinaturas</div>
                                <small class="text-muted">Faça upgrade do seu plano para ter mais visibilidade.</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>

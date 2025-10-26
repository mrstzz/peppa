<?php
// app/Views/partials/_supermercado_detalhes.php
//
// Esta view parcial recebe as variáveis do CategoriaController:
// $nome, $descricao, $imagemUrl, $subcategorias, $comerciantesDestaque, $ofertasDestaque
//
?>

<img src="<?= htmlspecialchars($imagemUrl ?? '...') ?>" 
     class="rounded-top mb-3" 
     alt="<?= htmlspecialchars($nome ?? '') ?>"
     width="750"  height="550">

<p class="lead"><?= htmlspecialchars($descricao ?? 'Encontre as melhores ofertas...') ?></p>

<h5 class="mt-4">Principais Seções:</h5>
<div class="mb-3">
    <?php if (!empty($subcategorias)): ?>
        <?php foreach ($subcategorias as $sub): ?>
            <a href="/buscar?categoria=<?= urlencode($nome) ?>&secao=<?= urlencode($sub) ?>" 
               class="btn btn-outline-secondary btn-sm mb-1">
                <?= htmlspecialchars($sub) ?>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted small">Nenhuma seção disponível.</p>
    <?php endif; ?>
</div>

<h5 class="mt-4">Ofertas em Destaque:</h5>
<?php if (!empty($ofertasDestaque)): ?>
    <div class="row g-2">
        <?php foreach ($ofertasDestaque as $oferta): ?>
            <div class="col-md-6">
                <div class="card card-body small h-100">
                    <strong><?= htmlspecialchars($oferta['produto']) ?></strong>
                    <p class="mb-1 text-success fw-bold fs-5"><?= htmlspecialchars($oferta['preco']) ?></p>
                    <span class="text-muted small">
                        No <?= htmlspecialchars($oferta['comercianteNome']) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-muted small">Nenhuma oferta em destaque esta semana.</p>
<?php endif; ?>


<h5 class="mt-4">Supermercados em Destaque:</h5>
<?php if (!empty($comerciantesDestaque)): ?>
    <div class="list-group list-group-flush">
        <?php foreach ($comerciantesDestaque as $comerciante): ?>
            <a href="/comerciante/<?= $comerciante['slug'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ps-0">
                <div class="d-flex align-items-center">
                    <img src="<?= htmlspecialchars($comerciante['logo']) ?>" alt="Logo" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                    <div>
                        <strong class="mb-0"><?= htmlspecialchars($comerciante['nome']) ?></strong>
                        <div class="small text-muted"><?= htmlspecialchars($comerciante['bairro']) ?></div>
                    </div>
                </div>
                <span class="badge bg-primary rounded-pill">Ver Perfil</span>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-muted small">Nenhum comerciante em destaque no momento.</p>
<?php endif; ?>

<a href="/buscar?categoria=<?= urlencode($nome) ?>" class="btn btn-primary w-100 mt-4">
    Ver todos os Supermercados
</a>
<?php
// Este arquivo é uma "View Parcial".
// Ele recebe as variáveis $nome, $descricao, $imagemUrl, etc.
// do CategoriaController.
?>

<img width="50%" src="<?= htmlspecialchars($imagemUrl ?? '') ?>" class="img-fluid rounded-top mb-3" alt="<?= htmlspecialchars($nome ?? '') ?>">

<p class="lead"><?= htmlspecialchars($descricao ?? 'Sem descrição.') ?></p>

<h5 class="mt-4">O que você encontra:</h5>
<ul>
    <?php if (!empty($itens_exemplo)): ?>
        <?php foreach ($itens_exemplo as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
    <?php endif; ?>
    <li>E muito mais...</li>
</ul>

<a href="/buscar?categoria=<?= urlencode($nome ?? '') ?>" class="btn btn-primary mt-3">Ver Comerciantes</a>
<?php
// app/Views/partials/_supermercado_detalhes.php
//
// Esta view parcial recebe as variáveis do CategoriaController:
// $nome, $descricao, $imagemUrl, $subcategorias, $comerciantesDestaque, $ofertasDestaque
//
?>


<img src="<?= htmlspecialchars($imagemUrl ?? 'https://placehold.co/600x400/cccccc/999999?text=Imagem') ?>" 
     class="w-full max-h-64 object-cover rounded-lg mb-4" 
     alt="<?= htmlspecialchars($nome ?? '') ?>">

<p class="text-xl text-gray-600 mb-6"><?= htmlspecialchars($descricao ?? 'Encontre as melhores ofertas...') ?></p>

<h5 class="text-lg font-semibold text-gray-800 mt-6 mb-3">Principais Seções:</h5>
<div class="flex flex-wrap gap-2 mb-4">
    <?php if (!empty($subcategorias)): ?>
        <?php foreach ($subcategorias as $sub): ?>
            <a href="/buscar?categoria=<?= urlencode($nome) ?>&secao=<?= urlencode($sub) ?>" 
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-1 rounded-full transition-colors">
                <?= htmlspecialchars($sub) ?>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-500 text-sm">Nenhuma seção disponível.</p>
    <?php endif; ?>
</div>

<h5 class="text-lg font-semibold text-gray-800 mt-6 mb-3">Ofertas em Destaque:</h5>
<?php if (!empty($ofertasDestaque)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <?php foreach ($ofertasDestaque as $oferta): ?>
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg h-full">
                <strong class="text-gray-900"><?= htmlspecialchars($oferta['produto']) ?></strong>
                <p class="mb-1 text-green-600 font-bold text-xl"><?= htmlspecialchars($oferta['preco']) ?></p>
                <span class="text-gray-500 text-sm">
                    No <?= htmlspecialchars($oferta['comercianteNome']) ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-gray-500 text-sm">Nenhuma oferta em destaque esta semana.</p>
<?php endif; ?>


<h5 class="text-lg font-semibold text-gray-800 mt-6 mb-3">Supermercados em Destaque:</h5>
<?php if (!empty($comerciantesDestaque)): ?>
    <div class="divide-y divide-gray-200 border-t border-gray-200">
        <?php foreach ($comerciantesDestaque as $comerciante): ?>
            <a href="/comerciante/<?= $comerciante['slug'] ?>" class="flex justify-between items-center py-4 px-2 hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                    <img src="<?= htmlspecialchars($comerciante['logo']) ?>" alt="Logo" class="rounded-md mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                    <div>
                        <strong class="text-gray-900"><?= htmlspecialchars($comerciante['nome']) ?></strong>
                        <div class="text-sm text-gray-500"><?= htmlspecialchars($comerciante['bairro']) ?></div>
                    </div>
                </div>
                <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">
                    Ver Perfil
                </span>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-gray-500 text-sm">Nenhum comerciante em destaque no momento.</p>
<?php endif; ?>

<a href="/buscar?categoria=<?= urlencode($nome) ?>" 
   class="block w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-5 rounded-lg text-center mt-6 transition-colors">
    Ver todos os Supermercados
</a>
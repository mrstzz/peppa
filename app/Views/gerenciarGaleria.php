<?php
// app/Views/gerenciarGaleria.php

$title = 'Gerenciar Galeria';

ob_start();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Gerenciar Minha Galeria</h5>
                    <a href="/dashboard-comerciante" class="btn btn-sm btn-outline-secondary">Voltar ao Dashboard</a>
                </div>
                <div class="card-body">
                    <!-- Formulário de Upload -->
                    <div class="mb-5 p-4 border rounded">
                        <h5 class="mb-3">Adicionar Novas Mídias</h5>
                        <form action="/galeria/salvar" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="foto_perfil" class="form-label">Foto de Perfil (substitui a atual)</label>
                                <input class="form-control" type="file" name="foto_perfil" id="foto_perfil">
                            </div>
                            <div class="mb-3">
                                <label for="fotos_galeria" class="form-label">Fotos para a Galeria (pode selecionar várias)</label>
                                <input class="form-control" type="file" name="fotos_galeria[]" id="fotos_galeria" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Mídias</button>
                        </form>
                    </div>

                    <!-- Galeria Atual -->
                    <h5>Minhas Mídias Atuais</h5>
                    <hr>
                    <div class="row row-cols-2 row-cols-md-4 g-3">
                        <?php if (!empty($midias)): ?>
                            <?php foreach($midias as $midia): ?>
                                <div class="col">
                                    <div class="card">
                                        <img src="/uploads/profiles/<?= htmlspecialchars($midia['caminho_arquivo']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <span class="badge bg-info mb-2"><?= ucfirst($midia['tipo']) ?></span>
                                            <form action="/galeria/deletar" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar esta mídia?');">
                                                <input type="hidden" name="midia_id" value="<?= $midia['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Você ainda não enviou nenhuma mídia.</p>
                        <?php endif; ?>
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

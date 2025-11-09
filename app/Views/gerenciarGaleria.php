<?php
// app/Views/gerenciarGaleria.php

$title = 'Gerenciar Galeria';

ob_start();
?>

<div class="container mx-auto px-4 my-16">
    <div class="flex justify-center">
        <div class="w-full lg:w-10/12">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 border-b flex justify-between items-center">
                    <h5 class="text-xl font-semibold text-gray-800">Gerenciar Minha Galeria</h5>
                    <a href="/dashboard-comerciante" class="border border-gray-300 text-gray-700 hover:bg-gray-100 font-semibold py-2 px-4 rounded-lg text-sm transition-colors">Voltar ao Dashboard</a>
                </div>
                <div class="p-6">
                    <div class="mb-8 p-6 border border-gray-200 rounded-lg bg-gray-50">
                        <h5 class="text-lg font-semibold mb-4 text-gray-800">Adicionar Novas Mídias</h5>
                        <form action="/galeria/salvar" method="POST" enctype="multipart/form-data" class="space-y-4">
                            <div>
                                <label for="foto_perfil" class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil (substitui a atual)</label>
                                <input class="w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white
                                              file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold
                                              file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" type="file" name="foto_perfil" id="foto_perfil">
                            </div>
                            <div>
                                <label for="fotos_galeria" class="block text-sm font-medium text-gray-700 mb-1">Fotos para a Galeria (pode selecionar várias)</label>
                                <input class="w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-white
                                              file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold
                                              file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" type="file" name="fotos_galeria[]" id="fotos_galeria" multiple>
                            </div>
                            <div>
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-colors">Enviar Mídias</button>
                            </div>
                        </form>
                    </div>

                    <h5 class="text-lg font-semibold text-gray-800">Minhas Mídias Atuais</h5>
                    <hr class="my-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <?php if (!empty($midias)): ?>
                            <?php foreach($midias as $midia): ?>
                                <div class="col">
                                    <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                        <img src="/uploads/profiles/<?= htmlspecialchars($midia['caminho_arquivo']) ?>" class="w-full h-48 object-cover">
                                        <div class="p-4 text-center">
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-3"><?= ucfirst($midia['tipo']) ?></span>
                                            <form action="/galeria/deletar" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar esta mídia?');">
                                                <input type="hidden" name="midia_id" value="<?= $midia['id'] ?>">
                                                <button type="submit" class="w-full text-xs border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-1 px-3 rounded-lg">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-500 col-span-full">Você ainda não enviou nenhuma mídia.</p>
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
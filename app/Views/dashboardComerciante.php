<?php
// app/Views/dashboardComerciante.php

$title = 'Meu Dashboard';
// print_r($comerc); // Removido ou comentado
ob_start();
?>

<div class="container mx-auto px-4 my-16">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-1/3 px-4 mb-6 lg:mb-0">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-center">
                    <?php
                        // Define o caminho da foto de perfil. Usa placeholder se não houver.
                        $profilePic = !empty($comerc['foto_perfil'])
                            ? "/uploads/profiles/" . htmlspecialchars($comerc['foto_perfil'])
                            : "https://placehold.co/150x150/EFEFEF/333333?text=Perfil";
                    ?>
                    <img src="<?= $profilePic ?>" class="rounded-full mb-4 mx-auto" alt="Foto de Perfil" width="150" height="150" style="object-fit: cover;">
                    <h4 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($comerc['nome'] ?? 'Nome Indefinido') ?></h4>
                    <p class="text-gray-500">ID do Perfil: #<?= htmlspecialchars($comerc['id'] ?? 'N/A') ?></p>
                </div>
                <ul class="divide-y divide-gray-200">
                    <li class="px-6 py-4 flex justify-between items-center">
                        <span class="text-gray-600">Status do Perfil</span>
                        <?php 
                            $status = htmlspecialchars($comerc['status'] ?? 'indefinido');
                            $badge_class = 'bg-gray-100 text-gray-800'; // default
                            if ($status === 'ativo') $badge_class = 'bg-green-100 text-green-800';
                            if ($status === 'provisorio') $badge_class = 'bg-yellow-100 text-yellow-800';
                            if ($status === 'suspenso') $badge_class = 'bg-red-100 text-red-800';
                        ?>
                        <span class="inline-block <?= $badge_class ?> text-xs font-semibold px-3 py-1 rounded-full"><?= ucfirst($status) ?></span>
                    </li>
                    <li class="px-6 py-4 flex justify-between items-center">
                        <span class="text-gray-600">Plano Contratado</span>
                        <span class="font-semibold text-red-600"><?= ucfirst(str_replace('_', ' ', $comerc['plano'] ?? 'Nenhum')) ?></span>
                    </li>
                    <li class="px-6 py-4 flex justify-between items-center">
                        <span class="text-gray-600">Expira em</span>
                        <span class="text-gray-800"><?= !empty($comerc['plano_expira_em']) ? date('d/m/Y', strtotime($comerc['plano_expira_em'])) : '-' ?></span>
                    </li>
                </ul>
                <div class="p-6 space-y-3">
                    <a href="/perfil/<?= htmlspecialchars($comerc['id'] ?? '') ?>" class="block w-full text-center border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-2 px-4 rounded-lg transition-colors" target="_blank">Ver Meu Perfil Público</a>
                    <a href="/logout" class="block w-full text-center border border-gray-300 text-gray-700 hover:bg-gray-100 font-semibold py-2 px-4 rounded-lg transition-colors">Sair da Conta</a>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 px-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h5 class="text-xl font-semibold text-gray-800">Gerenciamento do Perfil</h5>
                </div>
                <div class="p-6">
                    <h5 class="text-lg font-semibold text-gray-800">Complete seu perfil para atrair mais clientes</h5>
                    <p class="text-gray-600 mb-6">Mantenha suas informações, fotos e vídeos sempre atualizados para ter mais destaque na plataforma.</p>
                    <div class="divide-y divide-gray-200">
                        <a href="/perfil/editar" class="py-4 flex items-center group">
                            <i class="bi bi-person-lines-fill text-2xl mr-4 text-red-600"></i>
                            <div>
                                <div class="font-semibold text-gray-800 group-hover:text-red-600">Editar Informações do Perfil</div>
                                <small class="text-gray-500">Atualize sua descrição, tópicos e filtros.</small>
                            </div>
                        </a>
                        <a href="/galeria/gerenciar" class="py-4 flex items-center group">
                            <i class="bi bi-images text-2xl mr-4 text-red-600"></i>
                            <div>
                                <div class="font-semibold text-gray-800 group-hover:text-red-600">Gerenciar Galeria de Fotos e Vídeos</div>
                                <small class="text-gray-500">Faça upload, defina sua foto de capa e organize sua mídia.</small>
                            </div>
                        </a>
                        <a href="/planos" class="py-4 flex items-center group">
                            <i class="bi bi-gem text-2xl mr-4 text-red-600"></i>
                            <div>
                                <div class="font-semibold text-gray-800 group-hover:text-red-600">Meus Planos e Assinaturas</div>
                                <small class="text-gray-500">Faça upgrade do seu plano para ter mais visibilidade.</small>
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
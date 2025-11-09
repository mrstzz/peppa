<?php
// app/Views/dashboard.php

$title = 'Dashboard';
// print_r($user); // Removido ou comentado para não quebrar o layout
ob_start();
?>

<div class="container mx-auto px-4 my-16">
    <div class="flex justify-center">
        <div class="w-full md:w-10/12 lg:w-8/12">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="p-6 md:p-10">
                    <h1 class="text-4xl font-bold mb-3 text-gray-800">
                        Bem-vindo(a), <span class="text-red-600"><?= htmlspecialchars($user['nome']) ?></span>!
                    </h1>
                    <p class="text-lg text-gray-600">Este é o seu painel de controle. Aqui você pode gerenciar suas informações e atividades.</p>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Detalhes da sua Conta</h3>
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <strong class="text-gray-700">Nome:</strong> <?= htmlspecialchars($user['nome']) ?>
                            </li>
                            <li class="py-3">
                                <strong class="text-gray-700">Email:</strong> <?= htmlspecialchars($user['email']) ?>
                            </li>
                            <li class="py-3">
                                <strong class="text-gray-700">Membro desde:</strong> <?= date('d/m/Y', strtotime($user['criado_em'])) ?>
                                <strong class="ml-2">às</strong> <?= date('H:i:s', strtotime($user['criado_em'])) ?>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 border-t border-gray-200 pt-6">
                         <a href="/logout" class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-semibold py-2 px-5 rounded-lg transition-colors">Sair da Conta</a>
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
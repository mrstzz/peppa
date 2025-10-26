<?php
// app/Views/dashboard.php

$title = 'Dashboard';
print_r($user);
ob_start();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h1 class="card-title display-6 fw-bold mb-3">
                        Bem-vindo(a), <span class="text-danger"><?= htmlspecialchars($user['nome']) ?></span>!
                    </h1>
                    <p class="card-text text-muted">Este é o seu painel de controle. Aqui você pode gerenciar suas informações e atividades.</p>

                    <div class="mt-4 border-top pt-4">
                        <h3 class="fs-5 fw-semibold mb-3">Detalhes da sua Conta</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?>
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Membro desde:</strong> <?= date('d/m/Y', strtotime($user['criado_em'])) ?>
                                <strong>às</strong> <?= date('H:i:s', strtotime($user['criado_em'])) ?>

                            </li>
                        </ul>
                    </div>
                    <div class="mt-4 border-top pt-4">
                         <a href="/logout" class="btn btn-outline-danger">Sair da Conta</a>
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

<?php
// app/Views/auth/register.php

// A variável $type é passada pelo AuthController
use App\Controllers\AuthController;

extract($_GET);
$isComerciante = isset($type) && $type === 'comerciante';

$title = $isComerciante ? 'Cadastro de Comerciante' : 'Cadastro de Cliente';

$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);

ob_start();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Título dinâmico -->
                    <h2 class="card-title text-center fw-bold mb-4">
                        <?= $isComerciante ? 'Crie sua conta como Comerciante' : 'Crie sua Conta como Cliente ' ?>
                    </h2>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Mensagem de análise para comerciantes -->
                    <?php if ($isComerciante): ?>
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">Processo de Verificação</h4>
                            <p>Todas os comerciantes passam por uma análise de verificação de conteúdo e dados. Enquanto seu perfil não é analisado, ele ficará como <strong>provisório</strong>, liberando o acesso completo após a aprovação.</p>
                        </div>
                    <?php endif; ?>

                    <!-- O action do formulário inclui o tipo e o enctype permite upload de arquivos -->
                    <form action="/register?type=<?= $type ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Seu Nome" value="<?= htmlspecialchars($old_input['name'] ?? '') ?>" required>
                        </div>
                         <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control form-control-lg" id="cpf" name="cpf" placeholder="000.000.000-00" value="<?= htmlspecialchars($old_input['cpf'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="seu@email.com" value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" required>
                        </div>
                         <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control form-control-lg" id="telefone" name="telefone" placeholder="ex: 33988747211" value="<?= htmlspecialchars($old_input['telefone'] ?? '') ?>" required>
                        </div>
                        
                        <!-- Campo de catálogo SÓ para comerciantes -->
                        <?php if ($isComerciante): ?>
                        <div class="mb-3">
                            <label for="catalogo" class="form-label">Catálogo</label>
                            <input class="form-control form-control-lg" type="file" id="catalogo" name="catalogo[]" multiple>
                            <div class="form-text">
                                Caso não envie seu catálogo, gentileza deixar o telefone para contato.
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Crie uma senha forte" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirme sua Senha</label>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="Repita a senha" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger btn-lg">Criar Conta</button>
                        </div>
                        <p class="text-center text-muted mt-4">
                            Já tem uma conta? <a href="/login" class="fw-bold text-danger text-decoration-none">Faça login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>

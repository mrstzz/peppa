<?php
// app/Views/auth/login.php

$title = 'Login';
ob_start();

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title text-center fw-bold mb-4">Acessar sua Conta</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION['success'] ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="seu@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Sua senha" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger btn-lg">Entrar</button>
                        </div>
                        <p class="text-center text-muted mt-4">
                            Não tem uma conta? <a href="/register" class="fw-bold text-danger text-decoration-none">Cadastre-se</a>
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

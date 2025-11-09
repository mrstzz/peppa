<?php
// app/Views/auth/login.php

$title = 'Login';
ob_start();

?>

<div class="container mx-auto px-4 my-16">
    <div class="flex justify-center">
        <div class="w-full md:w-7/12 lg:w-5/12">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="p-6 md:p-10">
                    <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Acessar sua Conta</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                            <?= $_SESSION['success'] ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/login" method="POST">
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="email" name="email" placeholder="seu@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                            <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="password" name="password" placeholder="Sua senha" required>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg text-lg transition-colors">Entrar</button>
                        </div>
                        <p class="text-center text-gray-500 mt-6">
                            Não tem uma conta? <a href="/register" class="font-semibold text-red-600 hover:underline">Cadastre-se</a>
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
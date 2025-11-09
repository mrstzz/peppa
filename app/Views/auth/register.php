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

<script>
    function formatarCampo(campoTexto) {
        if (campoTexto.value.length <= 11) {
            campoTexto.value = mascaraCpf(campoTexto.value);
        } else {
            campoTexto.value = mascaraCnpj(campoTexto.value);
        }
    }
    function retirarFormatacao(campoTexto) {
        campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g,"");
    }
    function mascaraCpf(valor) {
        return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4");
    }
    function mascaraCnpj(valor) {
        return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g,"\$1.\$2.\$3\/\$4\-\$5");
    }
</script>

<div class="container mx-auto px-4 my-16">
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="p-6 md:p-10">
                    
                    <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">
                        <?= $isComerciante ? 'Crie sua conta como Comerciante' : 'Crie sua Conta como Cliente ' ?>
                    </h2>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                            <?= $_SESSION['error'] ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if ($isComerciante): ?>
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4" role="alert">
                            <h4 class="font-bold text-lg mb-2">Processo de Verificação</h4>
                            <p>Todos os comerciantes passam por uma análise de verificação de conteúdo e dados. Enquanto seu perfil não é analisado, ele ficará como <strong>provisório</strong>, liberando o acesso completo após a aprovação.</p>
                        </div>
                    <?php endif; ?>

                    <form action="/register?type=<?= $type ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="nome" name="nome" placeholder="Seu Nome" value="<?= htmlspecialchars($old_input['name'] ?? '') ?>" required>
                        </div>
                         <div class="mb-4">
                            <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="cpf" name="cpf" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);" value="<?= htmlspecialchars($old_input['cpf'] ?? '') ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="email" name="email" placeholder="seu@email.com" value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" required>
                        </div>
                         <div class="mb-4">
                            <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="telefone" name="telefone" placeholder="ex: 33988747211" value="<?= htmlspecialchars($old_input['telefone'] ?? '') ?>" required>
                        </div>
                        
                        <?php if ($isComerciante): ?>
                        <div class="mb-4">
                            <label for="catalogo" class="block text-sm font-medium text-gray-700 mb-1">Catálogo</label>
                            <input class="w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50
                                          file:mr-4 file:py-3 file:px-4 file:border-0 file:text-sm file:font-semibold
                                          file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" type="file" id="catalogo" name="catalogo[]" multiple>
                            <div class="text-sm text-gray-500 mt-1">
                                Caso não envie seu catálogo, gentileza deixar o telefone para contato.
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="nomeEmpresa" class="block text-sm font-medium text-gray-700 mb-1">Nome da Empresa</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="nomeEmpresa" name="nomeEmpresa" placeholder="ex: Atacadista LTDA" value="<?= htmlspecialchars($old_input['nomeEmpresa'] ?? '') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="site" class="block text-sm font-medium text-gray-700 mb-1">Site</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="site" name="site" placeholder="ex: atacadista.com.br" value="<?= htmlspecialchars($old_input['site'] ?? '') ?>" required>
                        </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                            <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="password" name="password" placeholder="Crie uma senha forte" required>
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirme sua Senha</label>
                            <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="password_confirmation" name="password_confirmation" placeholder="Repita a senha" required>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg text-lg transition-colors">Criar Conta</button>
                        </div>
                        <p class="text-center text-gray-500 mt-6">
                            Já tem uma conta? <a href="/login" class="font-semibold text-red-600 hover:underline">Faça login</a>
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
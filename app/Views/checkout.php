<?php
// app/Views/checkout.php

$title = 'Finalizar Pagamento';
ob_start();

// Simulação de dados do plano (em um app real, viria do banco)
$planos = [
    'plano_1' => ['nome' => 'Básico', 'valor' => 49.00],
    'plano_2' => ['nome' => 'Profissional', 'valor' => 89.00],
    'plano_3' => ['nome' => 'Premium', 'valor' => 129.00],
];
$planoInfo = $planos[$plano] ?? null;

?>

<div class="container mx-auto px-4 my-16 tab-content-container">
    <div class="flex justify-center">
        <div class="w-full lg:w-8/12">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-5 border-b text-center bg-gray-50">
                    <h4 class="text-xl font-semibold text-gray-800">Finalizar Assinatura</h4>
                </div>
                <div class="p-6">
                    <?php if ($planoInfo): ?>
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6" role="alert">
                            Você está assinando o <strong>Plano <?= $planoInfo['nome'] ?></strong> no valor de <strong>R$ <?= number_format($planoInfo['valor'], 2, ',', '.') ?></strong>.
                        </div>

                        <div class="border-b border-gray-200 mb-6">
                            <ul class="flex -mb-px" id="paymentMethodTab" role="tablist">
                                <li class="flex-1" role="presentation">
                                    <button class="w-full text-center py-4 px-1 border-b-2 border-red-600 text-red-600 font-semibold" 
                                            id="pix-tab" data-tab-target="#pix" type="button" role="tab" aria-selected="true">
                                        Pagar com PIX
                                    </button>
                                </li>
                                <li class="flex-1" role="presentation">
                                    <button class="w-full text-center py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium" 
                                            id="card-tab" data-tab-target="#card" type="button" role="tab" aria-selected="false">
                                        Cartão de Crédito
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class_alias="tab-pane" id="pix" role="tabpanel">
                                <p class="text-center text-gray-600 mb-6">Para pagar com PIX, clique no botão abaixo para gerar o QR Code.</p>
                                <form action="/pagamento/pix" method="POST" class="text-center">
                                    <input type="hidden" name="plano" value="<?= htmlspecialchars($plano) ?>">
                                    <input type="hidden" name="valor" value="<?= $planoInfo['valor'] ?>">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">Gerar QR Code PIX</button>
                                </form>
                            </div>

                            <div class_alias="tab-pane" id="card" role="tabpanel" class="hidden">
                                <form id="form-checkout" action="/pagamento/cartao" method="POST">
                                     <div id="form-checkout__cardNumber" class="border border-gray-300 rounded-lg p-3 mb-4"></div>
                                     <div class="flex flex-wrap -mx-2">
                                        <div class="w-full md:w-1/2 px-2">
                                            <div id="form-checkout__expirationDate" class="border border-gray-300 rounded-lg p-3 mb-4"></div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-2">
                                            <div id="form-checkout__securityCode" class="border border-gray-300 rounded-lg p-3 mb-4"></div>
                                        </div>
                                     </div>
                                     <input type="text" id="form-checkout__cardholderName" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" placeholder="Nome do titular" />
                                     <select id="form-checkout__issuer" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"></select>
                                     <select id="form-checkout__installments" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"></select>
                                     <select id="form-checkout__identificationType" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"></select>
                                     <input type="text" id="form-checkout__identificationNumber" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" placeholder="CPF" />
                                     <input type="email" id="form-checkout__cardholderEmail" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4" placeholder="E-mail" />
                                     <input type="hidden" name="plano" value="<?= htmlspecialchars($plano) ?>">
                                     <input type="hidden" name="valor" value="<?= $planoInfo['valor'] ?>">

                                     <div>
                                        <button type="submit" id="form-checkout__submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">Pagar com Cartão</button>
                                     </div>
                                </form>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">Plano inválido selecionado.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('SEU_PUBLIC_KEY_AQUI', {
        locale: 'pt-BR'
    });
    const cardForm = mp.cardForm({
        amount: "<?= (string)($planoInfo['valor'] ?? 0) ?>", // Garante que o valor esteja disponível
        iframe: true,
        form: {
            id: "form-checkout",
            cardNumber: { id: "form-checkout__cardNumber" },
            expirationDate: { id: "form-checkout__expirationDate" },
            securityCode: { id: "form-checkout__securityCode" },
            cardholderName: { id: "form-checkout__cardholderName" },
            issuer: { id: "form-checkout__issuer" },
            installments: { id: "form-checkout__installments" },
            identificationType: { id: "form-checkout__identificationType" },
            identificationNumber: { id: "form-checkout__identificationNumber" },
            cardholderEmail: { id: "form-checkout__cardholderEmail" },
        },
        callbacks: {
            onFormMounted: error => { if (error) return console.warn("Form Mounted Handling error: ", error); },
            onSubmit: event => {
                event.preventDefault();
                // O SDK vai tokenizar o cartão e enviar
            },
        },
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tab-content-container [role="tab"]');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = button.getAttribute('data-tab-target');
            const targetPanel = document.querySelector(targetId);
            
            // Container pai
            const container = button.closest('.tab-content-container');
            
            // Desativa todos os botões
            container.querySelectorAll('[role="tab"]').forEach(btn => {
                btn.setAttribute('aria-selected', 'false');
                btn.classList.remove('text-red-600', 'border-red-600');
                btn.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
            });
            
            // Esconde todos os painéis
            container.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                panel.classList.add('hidden');
            });
            
            // Ativa o botão clicado e seu painel
            button.setAttribute('aria-selected', 'true');
            button.classList.add('text-red-600', 'border-red-600');
            button.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'border-transparent');
            
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>
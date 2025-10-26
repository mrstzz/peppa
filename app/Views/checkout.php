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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4 class="mb-0">Finalizar Assinatura</h4>
                </div>
                <div class="card-body">
                    <?php if ($planoInfo): ?>
                        <div class="alert alert-info">
                            Você está assinando o <strong>Plano <?= $planoInfo['nome'] ?></strong> no valor de <strong>R$ <?= number_format($planoInfo['valor'], 2, ',', '.') ?></strong>.
                        </div>

                        <!-- Abas para PIX e Cartão -->
                        <ul class="nav nav-tabs nav-fill mb-4" id="paymentMethodTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pix-tab" data-bs-toggle="tab" data-bs-target="#pix" type="button" role="tab">Pagar com PIX</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="card-tab" data-bs-toggle="tab" data-bs-target="#card" type="button" role="tab">Cartão de Crédito</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Conteúdo da Aba PIX -->
                            <div class="tab-pane fade show active" id="pix" role="tabpanel">
                                <p class="text-center">Para pagar com PIX, clique no botão abaixo para gerar o QR Code.</p>
                                <form action="/pagamento/pix" method="POST" class="text-center">
                                    <input type="hidden" name="plano" value="<?= htmlspecialchars($plano) ?>">
                                    <input type="hidden" name="valor" value="<?= $planoInfo['valor'] ?>">
                                    <button type="submit" class="btn btn-primary btn-lg">Gerar QR Code PIX</button>
                                </form>
                            </div>

                            <!-- Conteúdo da Aba Cartão -->
                            <div class="tab-pane fade" id="card" role="tabpanel">
                                <!-- O formulário de cartão será injetado aqui pelo JS do Mercado Pago -->
                                <form id="form-checkout" action="/pagamento/cartao" method="POST">
                                     <div id="form-checkout__cardNumber" class="form-control mb-3"></div>
                                     <div class="row">
                                        <div class="col-md-6">
                                            <div id="form-checkout__expirationDate" class="form-control mb-3"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="form-checkout__securityCode" class="form-control mb-3"></div>
                                        </div>
                                     </div>
                                     <input type="text" id="form-checkout__cardholderName" class="form-control mb-3" placeholder="Nome do titular" />
                                     <select id="form-checkout__issuer" class="form-select mb-3"></select>
                                     <select id="form-checkout__installments" class="form-select mb-3"></select>
                                     <select id="form-checkout__identificationType" class="form-select mb-3"></select>
                                     <input type="text" id="form-checkout__identificationNumber" class="form-control mb-3" placeholder="CPF" />
                                     <input type="email" id="form-checkout__cardholderEmail" class="form-control mb-3" placeholder="E-mail" />
                                     <input type="hidden" name="plano" value="<?= htmlspecialchars($plano) ?>">
                                     <input type="hidden" name="valor" value="<?= $planoInfo['valor'] ?>">

                                     <div class="d-grid">
                                        <button type="submit" id="form-checkout__submit" class="btn btn-primary btn-lg">Pagar com Cartão</button>
                                     </div>
                                </form>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-danger">Plano inválido selecionado.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SDK do Mercado Pago -->
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('SEU_PUBLIC_KEY_AQUI', {
        locale: 'pt-BR'
    });
    const cardForm = mp.cardForm({
        amount: "<?= (string)$planoInfo['valor'] ?>",
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
                // O SDK vai tokenizar o cartão e enviar para o seu backend
            },
        },
    });
</script>


<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>

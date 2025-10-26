<?php
// app/Views/pagamentoPix.php
$title = 'Pagar com PIX';
ob_start();
?>
<div class="container my-5 text-center">
    <h2>Escaneie para Pagar</h2>
    <p>Use o app do seu banco para ler o QR Code abaixo.</p>
    <img src="data:image/jpeg;base64,<?= $qr_code_base64 ?>" alt="PIX QR Code">
    <h4 class="mt-4">Ou use o Copia e Cola</h4>
    <div class="input-group mb-3">
        <input type="text" class="form-control" value="<?= htmlspecialchars($qr_code_text) ?>" id="pixCode">
        <button class="btn btn-outline-secondary" type="button" onclick="copyPix()">Copiar</button>
    </div>
    <p class="text-muted">Após o pagamento, seu plano será ativado em alguns instantes.</p>
</div>
<script>
function copyPix() {
    var copyText = document.getElementById("pixCode");
    copyText.select();
    document.execCommand("copy");
    alert("Código PIX copiado!");
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>

<?php
// app/Views/pagamentoPix.php
$title = 'Pagar com PIX';
ob_start();
?>
<div class="container mx-auto px-4 my-16 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-3">Escaneie para Pagar</h2>
    <p class="text-lg text-gray-600 mb-6">Use o app do seu banco para ler o QR Code abaixo.</p>
    
    <img src="data:image/jpeg;base64,<?= $qr_code_base64 ?>" alt="PIX QR Code" class="inline-block border-4 border-white rounded-lg shadow-lg">
    
    <h4 class="text-2xl font-semibold mt-8 mb-3">Ou use o Copia e Cola</h4>
    <div class="flex max-w-md mx-auto mb-4">
        <input type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none bg-gray-50" value="<?= htmlspecialchars($qr_code_text) ?>" id="pixCode" readonly>
        <button class="border border-l-0 border-gray-300 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 rounded-r-lg" type="button" onclick="copyPix()">Copiar</button>
    </div>
    
    <p class="text-gray-500">Após o pagamento, seu plano será ativado em alguns instantes.</p>
</div>
<script>
function copyPix() {
    var copyText = document.getElementById("pixCode");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // Para mobile
    document.execCommand("copy");
    
    // Feedback visual simples
    var btn = event.target;
    btn.innerText = 'Copiado!';
    setTimeout(() => { btn.innerText = 'Copiar'; }, 2000);
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/app.php';
?>
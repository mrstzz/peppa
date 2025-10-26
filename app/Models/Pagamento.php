<?php
// app/Models/Pagamento.php
namespace App\Models;
use PDO;

class Pagamento {
    protected $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function inserePixPayment($comercID, $plano, $valor, $mpId, $qrBase64, $qrText) {
        $sql = "INSERT INTO tes_pagamentos (comerc_id, tipo_pag_id, plano_selecionado, valor, mp_payment_id, qr_code_base64, qr_code_text)
                VALUES (?, 1, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$comercID, $plano, $valor, $mpId, $qrBase64, $qrText]);
    }


     public function buscaMpId($mpPaymentId) {
        $stmt = $this->pdo->prepare("SELECT * FROM tes_pagamentos WHERE mp_payment_id = ?");
        $stmt->execute([$mpPaymentId]);
        return $stmt->fetch();
    }

    /**
     * Atualiza o status de um pagamento.
     */
    public function updateStatus($mpPaymentId, $status) {
        $stmt = $this->pdo->prepare("UPDATE tes_pagamentos SET status_pagamento = ? WHERE mp_payment_id = ?");
        return $stmt->execute([$status, $mpPaymentId]);
    }

    
}

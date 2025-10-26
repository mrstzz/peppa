<?php
// app/Controllers/PagamentoController.php

namespace App\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use App\Models\Pagamento;
use App\Models\Comerciante;
use App\Core\Controller;

class PagamentoController extends Controller {
    private $pagamentoModel;
    private $comercianteModel;

    public function __construct() {
        // A inicialização agora é feita com MercadoPagoConfig
        MercadoPagoConfig::setAccessToken($_ENV['MERCADOPAGO_ACCESS_TOKEN']);
        $pdo = \Database::getInstance();
        $this->pagamentoModel = new Pagamento($pdo);
        $this->comercianteModel = new Comerciante($pdo);
    }

    public function gerarPix() {
        $plano = $_POST['plano'];
        $valor = (float)$_POST['valor'];
        $comercId = $_SESSION['user_id'];
        $comercInfo = $this->comercianteModel->buscaId($comercId);

        try {
            // Cria um cliente de pagamento
            $client = new PaymentClient();
            
            // Monta o corpo da requisição
            $request = [
                "transaction_amount" => $valor,
                "description" => "Assinatura Plano " . ucfirst(str_replace('_', ' ', $plano)),
                "payment_method_id" => "pix",
                "payer" => [
                    "email" => $comercInfo['email'],
                    "first_name" => explode(' ', $comercInfo['nome'])[0],
                    "last_name" => end(explode(' ', $comercInfo['nome'])),
                ]
            ];

            // Cria o pagamento
            $payment = $client->create($request);

            if ($payment->id) {
                $this->pagamentoModel->inserePixPayment(
                    $comercId, $plano, $valor, $payment->id,
                    $payment->point_of_interaction->transaction_data->qr_code_base64,
                    $payment->point_of_interaction->transaction_data->qr_code
                );
                $this->view('pagamentoPix', [
                    'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64, 
                    'qr_code_text' => $payment->point_of_interaction->transaction_data->qr_code
                ]);
            } else {
                throw new \Exception("Erro ao obter ID do pagamento.");
            }

        } catch (MPApiException $e) {
            // Captura erros específicos da API do Mercado Pago
            error_log("Erro na API do Mercado Pago: " . $e->getApiResponse()->getContent());
            $_SESSION['error'] = 'Erro de comunicação com o gateway de pagamento.';
            $this->redirect('/checkout?plano=' . $plano);
        } catch (\Exception $e) {
            // Captura outros erros
            error_log("Erro ao gerar PIX: " . $e->getMessage());
            $_SESSION['error'] = 'Não foi possível gerar o PIX. Tente novamente.';
            $this->redirect('/checkout?plano=' . $plano);
        }
    }

    public function handleWebhook() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        http_response_code(200);

        if (isset($data['type']) && $data['type'] === 'payment') {
            try {
                $paymentId = $data['data']['id'];
                $client = new PaymentClient();
                $payment = $client->get($paymentId);

                if ($payment && $payment->status == 'approved') {
                    $pagamentoInterno = $this->pagamentoModel->buscaMpId($paymentId);

                    if ($pagamentoInterno && $pagamentoInterno['status_pagamento'] !== 'aprovado') {
                        $this->pagamentoModel->updateStatus($paymentId, 'aprovado');
                        $this->comercianteModel->ativaPlano(
                            $pagamentoInterno['comerc_id'],
                            $pagamentoInterno['plano_selecionado']
                        );
                    }
                }
            } catch (\Exception $e) {
                // É importante logar o erro, mas não retornar um status de erro para o MP
                error_log("Erro no webhook do Mercado Pago: " . $e->getMessage());
            }
        }
    }
}

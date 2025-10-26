<?php
// app/Controllers/UserController.php

namespace App\Controllers;

use App\Core\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\User; 

class UserController extends Controller {
    
    public function __construct() {
        // Garante que apenas usuários logados possam enviar mensagens
        $this->authCheck(); 
    }

    /**
     * Processa o envio do formulário de contato via AJAX.
     */
    public function enviarContato() {
        // Define o cabeçalho como JSON para a resposta AJAX
        header('Content-Type: application/json');

        // Verifica se é um método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false, 
                'message' => 'Método não permitido.'
            ]);
            return;
        }

        // Pega os dados do POST
        $assunto = $_POST['assunto'] ?? null;
        $mensagem = $_POST['mensagem'] ?? null;
        $userId = $_SESSION['user_id'] ?? 0;
        $userType = $_SESSION['user_type'] ?? 'desconhecido';

        // Validação simples
        if (empty($assunto) || empty($mensagem) || empty($userId)) {
            echo json_encode([
                'success' => false, 
                'message' => 'Todos os campos são obrigatórios.'
            ]);
            return;
        }

      $mail = new PHPMailer(true); // Passar 'true' habilita exceções

        try {
            // Configurações do Servidor (SMTP)
            // $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; // Habilite para debug detalhado
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME']; // e-mail de envio
            $mail->Password   = $_ENV['MAIL_PASS']; // Sua senha
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465; 
            $mail->CharSet    = 'UTF-8'; 


            // Remetente (Quem envia)
            $mail->setFrom($_ENV['MAIL_USERNAME'], 'Peppa/Suporte');

            // Destinatário (Quem recebe)
            $mail->addAddress($_ENV['MAIL_ADRESS'], 'Matheus (Suporte)');

            // (Opcional) Responder para:
            $userEmail = $_SESSION['user_email'] ?? 'nao-responder@site.com';
            $mail->addReplyTo($userEmail, "Usuário ID: $userId");

            
            // Conteúdo do E-mail
            $mail->isHTML(false); // O corpo do seu e-mail é texto plano
            
            // Títulos e Corpo (usando suas variáveis)
            $tituloEmail = "Suporte ($userType): $assunto";
            $corpoEmail = "Nova mensagem de suporte:\n\n";
            $corpoEmail .= "ID do Usuário: $userId\n";
            $corpoEmail .= "Tipo: $userType\n";
            $corpoEmail .= "Assunto: $assunto\n";
            $corpoEmail .= "Mensagem:\n$mensagem\n";
            
            $mail->Subject = $tituloEmail;
            $mail->Body    = $corpoEmail;

            // Envia o e-mail
            $mail->send();
            
            // Resposta de Sucesso para o AJAX
            echo json_encode([
                'success' => true, 
                'message' => 'Mensagem enviada com sucesso! Responderemos em breve.'
            ]);
            return;

        } catch (Exception $e) {
            error_log("PHPMailer Error: {$mail->ErrorInfo}");
            // Resposta de Erro para o AJAX
            echo json_encode([
                'success' => false, 
                'message' => "Erro ao enviar o e-mail. Tente novamente."
            ]);
            return;
        }


    }
}
<?php
// app/Controllers/UserController.php

namespace App\Controllers;

use App\Core\Controller;
// use App\Models\User; 

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

       
        $para = "suporte@teste.com";
        $tituloEmail = "Suporte ($userType): $assunto";
        $corpoEmail = "Nova mensagem de suporte:\n\n";
        $corpoEmail .= "ID do Usuário: $userId\n";
        $corpoEmail .= "Tipo: $userType\n";
        $corpoEmail .= "Assunto: $assunto\n";
        $corpoEmail .= "Mensagem:\n$mensagem\n";
        
        // $headers = "From: webmaster@seu-site.com"; // Pegue o email do usuário se preferir

        // Tenta enviar o e-mail
        // if (mail($para, $tituloEmail, $corpoEmail /*, $headers*/)) {
        //     echo json_encode([
        //         'success' => true, 
        //         'message' => 'Mensagem enviada com sucesso! Responderemos em breve.'
        //     ]);
        // } else {
        //     echo json_encode([
        //         'success' => false, 
        //         'message' => 'Erro ao enviar o e-mail. Tente novamente.'
        //     ]);
        // }

        // -----------------------------------------------------------------
        // Fim da lógica de e-mail (exemplo)


        // **Resposta MOCK (simulada) para testar o AJAX**
        echo json_encode([
            'success' => true, 
            'message' => 'Mensagem recebida com sucesso! (teste)'
        ]);
        
        return;
    }
}
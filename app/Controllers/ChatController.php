<?php
// app/Controllers/ChatController.php

namespace App\Controllers;

use App\Services\ChatService; // Importa o Serviço (correto)
use App\Core\Controller;         // CORREÇÃO 1: Removido o "App\" daqui
use Exception;

class ChatController extends Controller
{
    
    public function handle()
    {
        if (ob_get_level() > 0) {
            ob_clean();
        }
        error_reporting(0); 
        ini_set('display_errors', 0);

        
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Método não permitido']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $userMessage = $input['message'] ?? '';

        if (empty($userMessage)) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Mensagem vazia']);
            exit;
        }

        try {
            $chatService = new ChatService(); 
            
            $botReply = $chatService->getReply($userMessage);

            http_response_code(200);
            echo json_encode(['reply' => $botReply]);

        } catch (Exception $e) {
            error_log('Erro no ChatService: ' . $e->getMessage());
            
            http_response_code(503); // Service Unavailable
            echo json_encode(['reply' => 'Desculpe, o serviço de IA está indisponível no momento. Tente mais tarde.']);
        }
        
        exit;
    }
}
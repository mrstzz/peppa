<?php
// app/Services/ChatService.php

namespace App\Services;
use Exception;


class ChatService
{
    private string $apiKey;
    private string $apiUrl;

    private const SYSTEM_INSTRUCTION = "Você é o assistente virtual do site 'Peppa'.
Sua função é ajudar usuários a encontrar comerciantes (supermercados, drogarias, etc.),
entender como funciona a plataforma, planos de assinatura e como entrar em contato.
O site conecta clientes a comerciantes locais.
Para um usuário achar qualquer categoria, ele pode usar a barra de pesquisa ou clicar nos cards da home.
Para um comerciante se cadastrar, ele deve clicar em 'Anunciar como comerciante' ou 'Sou Comerciante'.
Para entrar em contato com um comerciante, o cliente pode ver o perfil (se o comerciante tiver assinado um plano).
* ** não precisa colocar isso sobre um topico de resposta.  
REGRAS RÍGIDAS:
1. Você NÃO responde sobre assuntos gerais (notícias, receitas, política, esportes, código de programação que não seja relacionado à API do site, etc).
2. Se o usuário perguntar algo fora do escopo, responda educadamente: 'Desculpe, sou apenas o assistente do site Peppa e só posso responder sobre nossos comerciantes e serviços.'
3. Seja conciso e prestativo, mas pode ser descontraído.
4. Não dê informações confidenciais.";

   
    public function __construct()
    {
        $this->apiKey = $_ENV['GEMINI_API_KEY'] ?? $_SERVER['GEMINI_API_KEY'] ?? null;
        if (empty($this->apiKey)) {
            throw new Exception('Chave de API não configurada no servidor.');
        }
        
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey;
    }



    /**
     * Envia a mensagem do usuário para a API e retorna a resposta.
     *
     * @param string $userMessage A mensagem pura do usuário.
     * @return string A resposta do bot.
     * @throws Exception Se a API falhar.
     */
    public function getReply(string $userMessage): string
    {
        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => self::SYSTEM_INSTRUCTION . "\n\nPergunta do usuário: " . $userMessage]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.2,
                "maxOutputTokens" => 500
            ]
        ];

        // Chama o método privado que faz a chamada cURL
        [$httpCode, $responseBody] = $this->callGeminiAPI($data);

        $geminiData = json_decode($responseBody, true);

        // Tratamento de erro melhorado
        if ($httpCode !== 200) {
            error_log("Gemini API Error (HTTP $httpCode): $responseBody");
            throw new Exception('Ocorreu um erro ao processar sua solicitação pela IA.');
        }

        $botReply = $geminiData['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if ($botReply) {
            return $botReply;
        }

        // Verifica se a API bloqueou a resposta (ex: por segurança)
        if (isset($geminiData['candidates'][0]['finishReason']) && $geminiData['candidates'][0]['finishReason'] !== 'STOP') {
             error_log("Gemini Response Blocked: " . $responseBody);
             return 'Não posso responder a essa solicitação por motivos de segurança.';
        }

        throw new Exception('Não consegui gerar uma resposta para isso. Tente reformular.');
    }

    /**
     * Executa a chamada cURL para a API Gemini.
     *
     * @param array $data O payload para enviar.
     * @return array [http_code, response_body]
     * @throws Exception Se o cURL falhar.
     */
    private function callGeminiAPI(array $data): array
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Manter para ambiente local (XAMPP/WAMP)

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            // Loga o erro real para o servidor
            error_log("cURL Error: " . $error);
            // Lança uma exceção amigável para o usuário
            throw new Exception('Desculpe, o serviço de IA está indisponível no momento. Tente mais tarde.');
        }
        
        curl_close($ch);

        return [$httpCode, $response];
    }
}
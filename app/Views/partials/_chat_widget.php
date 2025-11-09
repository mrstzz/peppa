<!-- 
============================================================
   Chat Widget (v.0.0.2)
   - Endpoint /api/chat
============================================================
-->
<div id="chat-container" class="fixed bottom-4 right-4 z-50">
    
    <!-- Botão de "Balaão" para abrir o chat -->
    <button id="chat-bubble" class="bg-red-600 text-white w-16 h-16 rounded-full shadow-lg flex items-center justify-center
                                   hover:bg-red-700 transition-transform hover:scale-110">
        <i class="bi bi-chat-dots-fill text-3xl"></i>
    </button>

    <!-- Janela do Chat (inicialmente oculta) -->
    <div id="chat-window" class="hidden absolute bottom-20 right-0 w-80 sm:w-96 
                                bg-white rounded-lg shadow-xl border border-gray-200
                                flex flex-col"
         style="max-height: 70vh; height: 500px;">
        
        <!-- Cabeçalho da Janela -->
        <header class="bg-red-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h5 class="font-semibold text-lg">Assistente Peppa</h5>
            <button id="chat-close-btn" class="text-white hover:bg-red-700 p-1 rounded-full">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </header>
        
        <!-- Corpo (Mensagens) -->
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-4">
            <!-- Mensagem Inicial do Bot -->
            <div class="flex">
                <div class="bg-gray-200 text-gray-800 p-3 rounded-lg max-w-xs">
                    <p>Olá! Como posso ajudar você hoje?</p>
                </div>
            </div>
        </div>
        
        <!-- Rodapé (Formulário de Envio) -->
        <footer class="p-4 border-t border-gray-200 bg-white rounded-b-lg">
            <form id="chat-form" class="flex items-center gap-2">
                <input type="text" 
                       id="chat-input" 
                       placeholder="Digite sua mensagem..." 
                       autocomplete="off"
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 
                              focus:outline-none focus:ring-2 focus:ring-red-500">
                <button type="submit" 
                        class="bg-red-600 text-white rounded-lg px-4 py-2 font-semibold
                               hover:bg-red-700 transition-colors
                               disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </footer>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatContainer = document.getElementById('chat-container');
    const chatBubble = document.getElementById('chat-bubble');
    const chatWindow = document.getElementById('chat-window');
    const closeBtn = document.getElementById('chat-close-btn');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const messagesContainer = document.getElementById('chat-messages');
    const sendButton = chatForm.querySelector('button[type="submit"]');

    chatBubble.addEventListener('click', () => {
        chatWindow.classList.remove('hidden');
        chatBubble.classList.add('hidden');
    });
    closeBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
        chatBubble.classList.remove('hidden');
    });

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        addMessage(message, 'user');
        chatInput.value = '';
        sendButton.disabled = true;
        const typingIndicator = addMessage('Digitando...', 'bot', true);

        try {
            const response = await fetch('api/chat', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            typingIndicator.remove();
            
            const data = await response.json().catch(() => {
                throw new Error(`O servidor respondeu com status ${response.status} mas não era JSON.`);
            });

            if (!response.ok) {
                const errorMsg = data.reply || data.error || `Erro ${response.status}. Tente mais tarde.`;
                throw new Error(errorMsg);
            }

            addMessage(data.reply, 'bot');

        } catch (error) {
            console.error('Erro no fetch do chat:', error);
            typingIndicator?.remove(); 
            addMessage(error.message || 'Erro de conexão. Tente mais tarde.', 'bot');
        } finally {
            sendButton.disabled = false;
        }
    });

    // Função para adicionar mensagem 
    function addMessage(text, sender, isTyping = false) {
        const messageWrapper = document.createElement('div');
        const messageBubble = document.createElement('div');
        
        if (sender === 'user') {
            messageWrapper.className = 'flex justify-end';
            messageBubble.className = 'bg-red-600 text-white p-3 rounded-lg max-w-xs';
        } else {
            messageWrapper.className = 'flex justify-start';
            messageBubble.className = 'bg-gray-200 text-gray-800 p-3 rounded-lg max-w-xs';
            if (isTyping) {
                messageWrapper.id = 'typing-indicator';
                messageBubble.innerHTML = '<span class="animate-pulse">...</span>';
            }
        }
        
        if (!isTyping) {
            // Converte quebras de linha em <br> e escapa HTML para segurança
            const escapedText = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
            messageBubble.innerHTML = escapedText.replace(/\n/g, '<br>');
        }
        
        messageWrapper.appendChild(messageBubble);
        messagesContainer.appendChild(messageWrapper);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        return messageWrapper;
    }
});
</script>
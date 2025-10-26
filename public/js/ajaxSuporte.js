document.addEventListener('DOMContentLoaded', function() {
    
    const btnEnviar = document.getElementById('btnEnviarContato');
    
    if (btnEnviar) {
        btnEnviar.addEventListener('click', function() {
            const form = document.getElementById('formContatoAjax');
            const formData = new FormData(form);
            const feedbackDiv = document.getElementById('contatoFeedback');

            const assunto = formData.get('assunto');
            const mensagem = formData.get('mensagem');
            if (!assunto || !mensagem) {
                feedbackDiv.textContent = 'Por favor, preencha todos os campos.';
                feedbackDiv.className = 'alert alert-warning';
                feedbackDiv.style.display = 'block';
                return;
            }

            fetch('/contato/enviar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Sucesso
                    feedbackDiv.textContent = data.message;
                    feedbackDiv.className = 'alert alert-success';
                    feedbackDiv.style.display = 'block';
                    form.reset(); // Limpa o formulário
                } else {
                    // Erro
                    feedbackDiv.textContent = data.message || 'Ocorreu um erro.';
                    feedbackDiv.className = 'alert alert-danger';
                    feedbackDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Erro no AJAX:', error);
                feedbackDiv.textContent = 'Erro de conexão. Tente novamente.';
                feedbackDiv.className = 'alert alert-danger';
                feedbackDiv.style.display = 'block';
            });
        });
    }

    const modal = document.getElementById('modalContato');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('contatoFeedback').style.display = 'none';
            document.getElementById('formContatoAjax').reset();
        });
    }
});
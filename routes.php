<?php

/** 
 *      ROTAS
 * @since 24/08/2025
 * @creator Matheus Montovaneli
 * <matheusmontovaneli2003@gmail.com>
*/


// routes.php
// O router é instanciado no index.php e este arquivo é carregado.
// As rotas são definidas aqui, mapeando uma URI e um método HTTP


// ROTAS GERAIS
$router->get('', 'HomeController@index');
$router->get('info-comerciante', 'HomeController@infoComerciante');
$router->post('comerciantes', 'HomeController@listaComerciantes');
$router->get('categoria/detalhes', 'CategoriaController@detalhes');

//Rota Suporte

$router->post('contato/enviar', 'UserController@enviarContato');

// Rotas de Autenticação
$router->get('login', 'AuthController@loginForm');
$router->get('register', 'AuthController@registerForm');
$router->get('logout', 'AuthController@logout');
$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');

// Rotas de Dashboard de Cliente
$router->get('dashboard', 'AuthController@dashboard');

// --- ROTAS PARA Comerciantes ---
$router->get('dashboard-comerciante', 'ComercianteController@dashboard');
$router->get('planos', 'ComercianteController@planos');
$router->post('planos/assinar', 'ComercianteController@assinarPlano');
$router->get('galeria/gerenciar', 'ComercianteController@gerenciarGaleria');
$router->post('galeria/salvar', 'ComercianteController@salvarMidia');
$router->post('galeria/deletar', 'ComercianteController@deletarMidia');
$router->get('perfil/editar', 'ComercianteController@editarPerfilForm');
$router->post('perfil/salvar', 'ComercianteController@salvarPerfil');



// --- ROTAS DE PAGAMENTO ---
$router->get('checkout', 'ComercianteController@checkout'); // Adicionar este método no ComercianteController
$router->post('pagamento/pix', 'PagamentoController@gerarPix');
$router->post('pagamento/cartao', 'PagamentoController@processarCartao');
$router->get('pagamento/sucesso', 'PagamentoController@sucesso');


// --- ROTA DO WEBHOOK ---
// Esta é a URL que você configurará no painel do Mercado Pago
$router->post('webhook/mercadopago', 'PagamentoController@handleWebhook');


// --- ROTA PARA PERFIL PÚBLICO ---
// O (\d+) captura um ou mais dígitos (o ID) e passa para o controller
$router->get('perfil/(\d+)', 'HomeController@verPerfil');
<?php
// app/Controllers/AuthController.php

namespace App\Controllers;

use App\Core\Controller; 
use App\Models\User;
use App\Models\Comerciante; 
require_once __DIR__ . '/../../core/ImageUploader.php'; 


class AuthController extends Controller {

    protected $userModel;
    protected $comercianteModel;

    public function __construct() {
        $pdo = \Database::getInstance();
        $this->userModel = new User($pdo);
        $this->comercianteModel = new Comerciante($pdo);
    }


    public function loginForm() {
        $this->view('auth/login');
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // 1. Tenta encontrar como cliente
        $user = $this->userModel->procuraEmailExistente($email);
        if ($user && password_verify($password, $user['senha'])) {
            // É um cliente, loga normalmente
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'cliente'; // Guarda o tipo na sessão
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['user_nome'] = $user['nome'];
            $this->redirect('/dashboard');
            return;
        }

        // 2. Se não for cliente, tenta encontrar como comerciantes
        $comerc = $this->comercianteModel->procuraEmailExistente($email);
        if ($comerc && password_verify($password, $comerc['senha'])) {
            // É uma comercanhante, verifica o status
            if ($comerc['status'] === 'provisorio') {
                $_SESSION['error'] = 'Seu acesso ainda está em análise, gentileza aguardar.';
                $this->redirect('/login');
                return;
            }

            $_SESSION['user_id'] = $comerc['id'];
            $_SESSION['user_type'] = 'comerciante'; // Guarda o tipo na sessão
            $_SESSION['user_nome'] = $comerc['nome'];
            $_SESSION['user_email'] = $comerc['email'];
            $this->redirect('/dashboard-comerciante'); // Redireciona para um dashboard diferente
            return;
        }

        // 3. Se não encontrou em nenhuma tabela
        $_SESSION['error'] = 'Email ou senha inválidos.';
        $this->redirect('/login');
    }

    public function registerForm() {
        $this->view('auth/register');
    }

    public function register() {
        $type = $_GET['type'] ?? 'usuario';

        $nome = $_POST['nome'] ?? '';
        $nomeEmpresa = $_POST['nomeEmpresa'] ?? '';
        $site = $_POST['site'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        // Salva os dados do formulário na sessão para repopular em caso de erro
        // Removemos as senhas por segurança.
        $old_input = $_POST;
        unset($old_input['password']);
        unset($old_input['password_confirmation']);
        $_SESSION['old_input'] = $old_input;


        if (empty($nome) || empty($email) || empty($password) || empty($telefone) || empty($cpf)) {
            $_SESSION['error'] = 'Todos os campos são obrigatórios.';
            $this->redirect('/register');
            return;
        }

        if ($password !== $password_confirmation) {
            $_SESSION['error'] = 'As senhas não coincidem.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register?type=usuario';
            $this->redirect($redirect_url);
            return;
        }
        
        if ($this->userModel->procuraEmail($email)) {
            $_SESSION['error'] = 'Este email já está cadastrado.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register?type=usuario';
            $this->redirect($redirect_url);
            return;
        }

        if ($this->userModel->buscaCpf($cpf)) {
            $_SESSION['error'] = 'Este CPF já está cadastrado.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register?type=usuario';
            $this->redirect($redirect_url);
            return;
        }
        
        if ($this->userModel->buscaTelefone($telefone)) {
            $_SESSION['error'] = 'Este telefone já está cadastrado.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register?type=usuario';
            $this->redirect($redirect_url);
            return;
        }


        if (!$this->userModel->validaCPF($cpf)) {
            $_SESSION['error'] = 'CPF INVÁLIDO.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register?type=usuario';
            $this->redirect($redirect_url);
            return;
        }

        if (!$this->userModel->validaCell($telefone)) {
            $_SESSION['error'] = 'Telefone INVÁLIDO.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register?type=usuario';
            $this->redirect($redirect_url);
            return;
        }

        // Se todas as validações passaram, limpa os dados antigos da sessão
        unset($_SESSION['old_input']);


        $success = false;
        if ($type === 'comerciante') {
            // Chama o Model de Comerciante
            $success = $this->comercianteModel->insere($nome, $nomeEmpresa, $site, $email, $password, $telefone, $cpf);
        } else {
            // Chama o Model de Usuário (Cliente)
            $success = $this->userModel->insere($nome, $email, $password, $telefone, $cpf);
        }

        if ($success) {
            // Se o cadastro foi de Comerciante e enviaram fotos, processa o upload
            if ($type === 'comerciante' && isset($_FILES['catalogo'])) {
                $uploader = new \ImageUploader(__DIR__ . '/../../public/uploads/profiles');
                
                // O input `catalogo[]` envia os arquivos num formato diferente, precisamos reorganizar
                $files = $this->reArrayFiles($_FILES['catalogo']);
                foreach ($files as $file) {
                    $newFilenome = $uploader->upload($file);
                    if ($newFilenome) {
                        // Se o upload deu certo, salva o nome do arquivo no banco
                        $this->comercianteModel->insereFoto($success, $newFilenome);
                    }
                }
            }
            $_SESSION['success'] = 'Cadastro realizado com sucesso! Faça o login.';
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = 'Ocorreu um erro ao realizar o cadastro. Verifique os dados e tente novamente.';
            $redirect_url = ($type === 'comerciante') ? '/register?type=comerciante' : '/register';
            $this->redirect($redirect_url);
        }
    

    }


    private function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['nome']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

    public function dashboard() {
        $this->authCheck();
        $user = $this->userModel->buscaId($_SESSION['user_id']);
        $this->view('dashboard', ['user' => $user]);
    }

    public function dashboardComerc() {
        $this->authCheck();
        $comerc = $this->comercianteModel->buscaId($_SESSION['user_id']);
        $this->view('dashboardComerciante', ['comerc' => $comerc]);
    }
   

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        $this->redirect('/');
    }
}

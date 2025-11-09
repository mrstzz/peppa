<?php
// app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comerciante;


class HomeController extends Controller {
    protected $comercianteModel;

    public function __construct() {
        $pdo = \Database::getInstance();
        $this->comercianteModel = new Comerciante($pdo);
    }
    
    
    public function index() {
        $data = [
            'page_title' => 'Página Inicial', // Exemplo
            'show_chat' => true // Esta é a linha importante!
        ];
        $this->view('home',$data);
    }

    public function infoComerciante() {
        $this->view('infoComerciante');
    }

    public function listaComerciantes() {
        $comerciantes = $this->comercianteModel->getTodosAtivos();
        $this->view('listaComerciante', ['comerciantes' => $comerciantes]);
    }

    
    
    public function verPerfil($id) {
        $data = $this->comercianteModel->getPerfilAtivo($id);

        if (!$data) {
            // Redireciona para a home se o perfil não for encontrado ou não estiver ativo
            $this->redirect('/');
        }

        $this->view('perfil', $data);
    }

}

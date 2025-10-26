<?php
// app/Controllers/ComercianteController.php

namespace App\Controllers;

use App\Models\Comerciante;
use App\Core\Controller; 
require_once __DIR__ . '/../../core/ImageUploader.php';


class ComercianteController extends Controller {
    private $comercianteModel;

    public function __construct() {
        $this->authCheck(); // Garante que apenas usuários logados acessem
        if ($_SESSION['user_type'] !== 'comerciante') {
            $this->redirect('/'); // Garante que apenas comerciantes acessem
        }
        $this->comercianteModel = new Comerciante(\Database::getInstance());
    }


    public function checkout() {
        $plano = $_GET['plano'] ?? null;
        if (!$plano || !in_array($plano, ['plano_1', 'plano_2', 'plano_3'])) {
            // Se não houver plano ou for inválido, volta para a página de planos
            $this->redirect('/planos');
        }
        $this->view('checkout', ['plano' => $plano]);
    }

    public function dashboard() {
        $comerc = $this->comercianteModel->findById($_SESSION['user_id']);

        // Se o status for provisório e não tiver plano, redireciona para os planos
        if ($comerc['status'] === 'ativo' && is_null($comerc['plano'])) {
            $this->redirect('/planos');
        }

        $this->view('dashboardComerciante', ['comerc' => $comerc]);
    }

    public function planos() {
        $this->view('planos');
    }

    public function assinarPlano() {
        $plano = $_POST['plano'] ?? null;
        if (!$plano) {
            $this->redirect('/planos');
        }
        // Redireciona para a página de checkout, passando o plano na URL
        $this->redirect("/checkout?plano={$plano}");
    }

     public function gerenciarGaleria() {
        $midias = $this->comercianteModel->getMidias($_SESSION['user_id']);
        $this->view('gerenciarGaleria', ['midias' => $midias]);
    }

    public function salvarMidia() {
        $comercID = $_SESSION['user_id'];
        $uploader = new \ImageUploader(__DIR__ . '/../../public/uploads/profiles');

        // Processa a foto de perfil
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == UPLOAD_ERR_OK) {
            $newFilename = $uploader->upload($_FILES['foto_perfil']);
            if ($newFilename) {
                $this->comercianteModel->setProfilePic($comercID, $newFilename);
            }
        }

        // Processa as fotos da galeria
        if (isset($_FILES['fotos_galeria'])) {
            $files = $this->reArrayFiles($_FILES['fotos_galeria']);
            foreach ($files as $file) {
                if ($file['error'] == UPLOAD_ERR_OK) {
                    $newFilename = $uploader->upload($file);
                    if ($newFilename) {
                        $this->comercianteModel->addPhoto($comercID, $newFilename, 'galeria');
                    }
                }
            }
        }
        $this->redirect('/galeria/gerenciar');
    }

    public function deletarMidia() {
        $midiaId = $_POST['midia_id'] ?? 0;
        $comercID = $_SESSION['user_id'];
        
        // Deleta do disco e do banco
        $this->comercianteModel->deletePhoto($midiaId, $comercID);
        
        $this->redirect('/galeria/gerenciar');
    }


    private function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }
    
}

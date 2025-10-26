<?php
// app/Models/Comerciante.php

namespace App\Models;

use PDO;

class Comerciante {
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

      /**
     * Busca um perfil de comerciante pelo seu ID, incluindo os dados do perfil.
     * @param int $id O ID da comerciante.
     * @return mixed
     */
    public function findById($id) {
        // CORREÇÃO: Adicionamos um LEFT JOIN para a tabela de fotos, buscando a de tipo 'perfil'
        $sql = "SELECT 
                    a.id, a.nome, a.status, a.plano, a.plano_expira_em,
                    p.titulo_perfil, p.descricao_perfil,
                    f.caminho_arquivo AS foto_perfil
                FROM comerciantes a
                LEFT JOIN perfil_comerciantes p ON a.id = p.comerc_id
                LEFT JOIN comerciante_fotos f ON a.id = f.comerc_id AND f.tipo = 'perfil'
                WHERE a.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    public function findByEmail($email) {

        $stmt = $this->pdo->prepare('SELECT 1
                                    FROM 
                                        dual
                                    WHERE EXISTS 
                                        (SELECT 1 FROM users WHERE email = ?) OR EXISTS 
                                        (SELECT 1 FROM comerciantes WHERE email = ?)');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findEmailExists($email) {
        
        $stmt = $this->pdo->prepare('SELECT * FROM comerciantes WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }


    public function createComerciante($name, $email, $password, $telefone, $cpf, $type = 'comerciante') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $status = 'provisorio';
        $cpf = preg_replace('/\D/', '', $cpf);
        $telefone = ltrim ($telefone,'0');

        $this->pdo->beginTransaction();
        try {
            $sql = 'INSERT INTO comerciantes (nome, email, senha, telefone, cpf, status) VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$name, $email, $hashedPassword, $telefone, $cpf, $status]);
            
            $comercId = $this->pdo->lastInsertId();
            


             if ($type === 'comerciantes') {
                $this->assignGroup($comercId, 3);
            } else {
                error_log('erro');
            }
          
            $this->pdo->commit();
            return $comercId;

        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            if ($e->getCode() == 23000) { return false; }
            throw $e;
        }
    }

    public function assignGroup($comercId, $groupId) {
        // Insere na nova coluna comerc_id
        $sql = 'INSERT INTO acess_grupo (comerc_id, grupo_id) VALUES (?, ?)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$comercId, $groupId]);
    }

    /**
     * Atualiza o plano de uma comerciante.
     * @param int $comercId O ID da comerciante.
     * @param string $plano O nome do plano ('plano_1', 'plano_2', 'plano_3').
     * @return bool
     */
    public function updatePlano($comercId, $plano) {
        // Define a data de expiração para 30 dias a partir de hoje
        $dataAtual  = date('Y-m-d');
        $dataExpiracao=date('Y-m-d', strtotime('+1 year', strtotime($dataAtual)) );
        
        $sql = "UPDATE comerciantes SET plano = ?, plano_expira_em = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$plano, $dataExpiracao, $comercId]);
    }

    public function activatePlan($comercId, $plano) {
        $dataAtual  = date('Y-m-d');
        $dataExpiracao=date('Y-m-d', strtotime('+1 year', strtotime($dataAtual)) );
        
        $sql = "UPDATE comerciantes SET status = 'ativo', plano = ?, plano_expira_em = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$plano, $dataExpiracao, $comercId]);
    }

    /**
     * Busca todos os perfis de comerciantes que estão ativos,
     * incluindo a foto de perfil específica.
     * @return array
     */
    public function getAllActive() {
        // CORREÇÃO: Usamos MIN(f.caminho_arquivo) para agrupar as fotos e resolver
        // a incompatibilidade com o modo SQL 'only_full_group_by'.
        $sql = "SELECT a.*, MIN(f.caminho_arquivo) AS caminho_arquivo
                FROM comerciantes a
                LEFT JOIN comerciante_fotos f ON a.id = f.comerc_id AND f.tipo = 'perfil'
                WHERE a.status = 'ativo'
                GROUP BY a.id
                ORDER BY a.criado_em DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getPublicProfile($id) {
        // CORREÇÃO: Usamos um alias (AS comerc_id) para evitar conflito com o id da tabela de perfil
        $sqlPerfil = "SELECT
                        a.id AS comerc_id, a.nome,
                        p.titulo_perfil, p.descricao_perfil, p.sobre_mim, p.filtros
                      FROM comerciantes a
                      LEFT JOIN perfil_comerciantes p ON a.id = p.comerc_id
                      WHERE a.id = ? AND a.status = 'ativo'";
        $stmtPerfil = $this->pdo->prepare($sqlPerfil);
        $stmtPerfil->execute([$id]);
        $perfil = $stmtPerfil->fetch();

        if (!$perfil) {
            return false;
        }

        // Busca todas as mídias (fotos e vídeos) associadas
        $sqlMidias = "SELECT id, caminho_arquivo, tipo FROM comerciante_fotos WHERE comerc_id = ?";
        $stmtMidias = $this->pdo->prepare($sqlMidias);
        $stmtMidias->execute([$id]);
        $midias = $stmtMidias->fetchAll();

        return ['perfil' => $perfil, 'midias' => $midias];
    }


     public function getMidias($comercId) {
        $stmt = $this->pdo->prepare("SELECT id, caminho_arquivo, tipo FROM comerciante_fotos WHERE comerc_id = ?");
        $stmt->execute([$comercId]);
        return $stmt->fetchAll();
    }



     public function addPhoto($comercId, $filename, $tipo = 'galeria') {
        $sql = "INSERT INTO comerciante_fotos (comerc_id, caminho_arquivo, tipo) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$comercId, $filename, $tipo]);
    }

    /**
     * Define a foto de perfil de uma comerciante.
     * Primeiro, remove o status 'perfil' de qualquer foto antiga,
     * depois adiciona a nova foto com o status 'perfil'.
     * @param int $comercId O ID da comerciante.
     * @param string $filename O nome do novo arquivo de perfil.
     * @return bool
     */
    public function setProfilePic($comercId, $filename) {
        // Remove o status 'perfil' da foto antiga, se houver
        $this->pdo->prepare("UPDATE comerciante_fotos SET tipo = 'galeria' WHERE comerc_id = ? AND tipo = 'perfil'")->execute([$comercId]);
        
        // Adiciona a nova foto com o tipo 'perfil'
        return $this->addPhoto($comercId, $filename, 'perfil');
    }
    

    public function deletePhoto($midiaId, $comercId) {
        // Primeiro, pega o nome do arquivo para deletar do disco
        $stmt = $this->pdo->prepare("SELECT caminho_arquivo FROM comerciante_fotos WHERE id = ? AND comerc_id = ?");
        $stmt->execute([$midiaId, $comercId]);
        $file = $stmt->fetchColumn();

        if ($file) {
            // Deleta o registro do banco
            $deleteStmt = $this->pdo->prepare("DELETE FROM comerciante_fotos WHERE id = ?");
            if ($deleteStmt->execute([$midiaId])) {
                // Se deletou do banco, deleta o arquivo físico
                $filePath = __DIR__ . '/../../public/uploads/profiles/' . $file;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                return true;
            }
        }
        return false;
    }



    
    
}

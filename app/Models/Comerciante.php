<?php
// app/Models/Comerciante.php

namespace App\Models;

use Database;
use PDO;

class Comerciante extends Database{
    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->conn = $pdo;
    }

      /**
     * Busca um perfil de comerciante pelo seu ID, incluindo os dados do perfil.
     * @param int $id O ID da comerciante.
     * @return mixed
     */
    public function buscaId($id) {

        $sql = "SELECT 
                    a.id, a.nome, a.status, a.plano, a.plano_expira_em,
                    p.titulo_perfil, p.descricao_perfil,
                    f.caminho_arquivo AS foto_perfil
                FROM comerciantes a
                LEFT JOIN perfil_comerciantes p ON a.id = p.comerc_id
                LEFT JOIN comerciante_fotos f ON a.id = f.comerc_id AND f.tipo = 'perfil'
                WHERE a.id = ?";
        $result = $this->consulta($sql,[$id]);
        return $result->fetch();
    }


    public function procuraEmail($email) {

       $sql = " SELECT 1
                FROM 
                    dual
                WHERE EXISTS 
                    (SELECT 1 FROM users WHERE email = $email) OR EXISTS 
                    (SELECT 1 FROM comerciantes WHERE email = ?)";
        $result = $this->consulta($sql,[$email]);
        return $result->fetch();
    }

    public function procuraEmailExistente($email) {
        
        $sql = "SELECT * FROM comerciantes WHERE email = ?";
        $result = $this->consulta($sql,[$email]);
        return $result->fetch();
    }


    public function insere($nome, $nomeEmpresa, $site, $email, $password, $telefone, $cpf, $type = 'comerciante') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $status = 'provisorio';
        $cpf = preg_replace('/\D/', '', $cpf);
        $telefone = ltrim ($telefone,'0');

        $this->pdo->beginTransaction();
        try {
            $sql = "INSERT INTO comerciantes (nome, nome_empresa, site, email, senha, telefone, cpf, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
            $params = [
                $nome,           // 1. nome
                $nomeEmpresa,    // 2. nome_empresa
                $site,           // 3. site
                $email,          // 4. email
                $hashedPassword, // 5. senha (use o HASH)
                $telefone,       // 6. telefone
                $cpf,            // 7. cpf
                $status          // 8. status
            ];

            $result = $this->consulta($sql, $params);

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
        
        // EXECUTE A CONSULTA (faltava esta linha)
        // Use try-catch para não quebrar a transação principal se falhar
        try {
            $this->consulta($sql, [$comercId, $groupId]);
            return true;
        } catch (\PDOException $e) {
            error_log("Falha ao associar grupo: " . $e->getMessage());
            // Lança a exceção para que o 'insere' possa fazer o rollBack
            throw $e; 
        }
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
        
        $sql = "UPDATE comerciantes SET plano = $plano, plano_expira_em = $dataExpiracao WHERE id = $dataAtual";
        $result = $this->consulta($sql);
        return $result;
    }

    public function ativaPlano($comercId, $plano) {
        $dataAtual  = date('Y-m-d');
        $dataExpiracao=date('Y-m-d', strtotime('+1 year', strtotime($dataAtual)) );
        
        $sql = "UPDATE comerciantes SET status = 'ativo', plano = ?, plano_expira_em = ? WHERE id = ?";
        $result = $this->consulta($sql);
        return $result;
    }

    /**
     * Busca todos os perfis de comerciantes que estão ativos,
     * incluindo a foto de perfil específica.
     * @return array
     */
    public function getTodosAtivos() {
        $sql = "SELECT a.*, MIN(f.caminho_arquivo) AS caminho_arquivo
                FROM comerciantes a
                LEFT JOIN comerciante_fotos f ON a.id = f.comerc_id AND f.tipo = 'perfil'
                WHERE a.status = 'ativo'
                GROUP BY a.id
                ORDER BY a.criado_em DESC";

        $result = $this->consulta($sql);
        return $result->fetchAll();
    }
    
    public function getPerfilAtivo($id) {
        // CORREÇÃO: Usamos um alias (AS comerc_id) para evitar conflito com o id da tabela de perfil
        $sqlPerfil = "SELECT
                        a.id AS comerc_id, a.nome,
                        p.titulo_perfil, p.descricao_perfil, p.sobre_mim, p.filtros
                      FROM comerciantes a
                      LEFT JOIN perfil_comerciantes p ON a.id = p.comerc_id
                      WHERE a.id = $id AND a.status = 'ativo'";
        $result = $this->consulta($sqlPerfil);
        $perfil = $result->fetch();

        if (!$perfil) {
            return false;
        }

        // Busca todas as mídias (fotos e vídeos) associadas
        $sqlMidias = "SELECT id, caminho_arquivo, tipo FROM comerciante_fotos WHERE comerc_id = $id";
        $result = $this->consulta($sqlMidias);
        $midias = $result->fetchAll();

        return ['perfil' => $perfil, 'midias' => $midias];
    }


     public function getMidias($comercId) {
        $sql = "SELECT id, caminho_arquivo, tipo FROM comerciante_fotos WHERE comerc_id = $comercId";
        $result = $this->consulta($sql);
        return $result->fetchAll();
    }



     public function insereFoto($comercId, $filenome, $tipo = 'galeria') {
        $sql = "INSERT INTO comerciante_fotos (comerc_id, caminho_arquivo, tipo) VALUES ($comercId, $filenome, $tipo)";
        return $sql;
    }

    /**
     * Define a foto de perfil de uma comerciante.
     * Primeiro, remove o status 'perfil' de qualquer foto antiga,
     * depois adiciona a nova foto com o status 'perfil'.
     * @param int $comercId O ID da comerciante.
     * @param string $filenome O nome do novo arquivo de perfil.
     * @return bool
     */
    public function setProfilePic($comercId, $filenome) {
        // Remove o status 'perfil' da foto antiga, se houver
        $sql = "UPDATE comerciante_fotos SET tipo = 'galeria' WHERE comerc_id = $comercId AND tipo = 'perfil'";
        $result = $this->consulta($sql);
        
        // Adiciona a nova foto com o tipo 'perfil'
        return $this->insereFoto($comercId, $filenome, 'perfil');
    }
    

    public function excluiFoto($midiaId, $comercId) {

        // Primeiro, pega o nome do arquivo para deletar do disco
        $sql = "SELECT caminho_arquivo FROM comerciante_fotos WHERE id = $midiaId AND comerc_id = $comercId";
        $result = $this->consulta($sql);
        $file = $result->fetchColumn();

        if ($file) {
            // Deleta o registro do banco
            $deleteSql = "DELETE FROM comerciante_fotos WHERE id = $midiaId";
            $resultDelete = $this->consulta($deleteSql);
            
            if ($resultDelete) {
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

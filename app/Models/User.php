<?php
// app/Models/User.php

namespace App\Models;

use PDO;

class User {
    protected $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function findById($id) {

        $stmt = $this->pdo->prepare('SELECT id, nome, email, telefone, criado_em FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByCPF($cpf) {
            $cpf = preg_replace('/\D/', '', $cpf);
            $stmt = $this->pdo->prepare('SELECT 1
                                    FROM 
                                        dual
                                    WHERE EXISTS 
                                        (SELECT 1 FROM users WHERE cpf = ?) OR EXISTS 
                                        (SELECT 1 FROM comerciantes WHERE cpf = ?)
                                    ');
            $stmt->execute([$cpf,$cpf]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findByEmail($email) {

        $stmt = $this->pdo->prepare ('SELECT 1
                                    FROM 
                                        dual
                                    WHERE EXISTS 
                                        (SELECT 1 FROM users WHERE email = ?) OR EXISTS 
                                        (SELECT 1 FROM comerciantes WHERE email = ?)
                                    ');
        $stmt->execute([$email,$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmailExists($email) {

            $stmt = $this->pdo->prepare ('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }




    public function findByCell($telefone) {
        $telefone = ltrim ($telefone,'0');
        $stmt = $this->pdo->prepare('SELECT 1
                                    FROM 
                                        dual
                                    WHERE EXISTS 
                                        (SELECT 1 FROM users WHERE telefone = ?) OR EXISTS 
                                        (SELECT 1 FROM comerciantes WHERE telefone = ?)
                                    ');
        $stmt->execute([$telefone,$telefone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
   

     function validaCPF(string $cpf) {
        // remove tudo que não for número
        $cpf = preg_replace('/\D/', '', $cpf);

        // precisa ter 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // elimina CPFs de números repetidos
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // valida cada dígito verificador
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += intval($cpf[$i]) * (($t + 1) - $i);
            }
            $resto = $soma % 11;
            $dv = ($resto < 2) ? 0 : 11 - $resto;

            if (intval($cpf[$t]) !== $dv) {
                return false;
            }
        }

        // se passou por tudo, retorna TRUE
        return true;
    }

    function validaCell(string $telefone) {
        // remove tudo que não for número
        $telefone = ltrim($telefone, '0');
        $telefone = preg_replace('/\D/', '', $telefone);

        

        // deve ter 10 (fixo) ou 11 dígitos (celular)
        $len = strlen($telefone);
        if ($len !== 10 && $len !== 11) {
            return false;
        }

        // separa DDD e número
        $ddd = substr($telefone, 0, 2);
        $numero = substr($telefone, 2);

        // valida DDD (01..99, mas geralmente 11..99 reais)
        if ($ddd < 11 || $ddd > 99) {
            return false;
        }

        // valida fixo (10 dígitos, começa com 2 a 5)
        if ($len === 10 && !preg_match('/^[2-5]\d{7}$/', $numero)) {
            return false;
        }

        // valida celular (11 dígitos, começa com 9)
        if ($len === 11 && !preg_match('/^9\d{8}$/', $numero)) {
            return false;
        }

        return true; // retorna o número normalizado
    }


     public function create($name, $email, $password, $telefone, $cpf, $type = 'usuario') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $cpf = preg_replace('/\D/', '', $cpf);
        $telefone = ltrim ($telefone,'0');
        $this->pdo->beginTransaction();

        try {
            $sql = 'INSERT INTO users (nome, email, senha, telefone, cpf) VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$name, $email, $hashedPassword, $telefone, $cpf]);
            
            $userId = $this->pdo->lastInsertId();
            
            if ($type === 'usuario') {
                $this->assignGroup($userId, 2);
            } else {
                error_log('erro');
            }

            $this->pdo->commit();
            return $userId;

        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            if ($e->getCode() == 23000) { return false; }
            throw $e;
        }
    }


    public function assignGroup($userId, $groupId) {
        $sql = 'INSERT INTO acess_grupo (client_id, grupo_id) VALUES (?, ?)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $groupId]);
    }
}



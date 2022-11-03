<?php

namespace Repository;

use DataBase\MySQL;

class UsuariosRepository
{
    private object $MySQL;
    const TABELA = 'tbl_user';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function getRegistroByEmail($email)
    {
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE email = :email';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function insertUser($fullname, $email, $phone, $password)
    {
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (fullname, email, phone, password) VALUES (:fullname, :email, :phone, :password)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados)
    {
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET fullname = :fullname, email = :email, phone = :phone, password = :password WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fullname', $dados['fullname']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':phone', $dados['phone']);
        $stmt->bindParam(':password', password_hash($dados['password'], PASSWORD_DEFAULT));
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}
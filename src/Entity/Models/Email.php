<?php

namespace models;

use lib\Core;
use PDO;

class Email
{
    protected $core;
    protected $id;
    protected $type;
    protected $address;
    protected $error = false;

    public function __construct()
    {
        $this->core = Core::getInstance();
        $this->table = 'email';
    }

    public function getError()
    {
        return $this->error;
    }

    public function setId($id = null)
    {
        if (empty($id)) {
            throw new Exception("Você deve informar o ID!");
        }
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Cria o cliente conforme os dados passados
     * @param  string $type
     * @param  string $address
     * @return string
     */
    public function createAddress($type = null, $address = null)
    {
        $return = null;
        try {
            if (!empty($type) && !empty($address)) {
                $this->core->db->beginTransaction();

                /**
                 * Insere os dados iniciais para criação do cliente
                 * @var PDO
                 */
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->table} SET type = :type, address = :address");

                $query->bindValue(':type', $type);
                $query->bindValue(':address', $address);

                //$query->debugDumpParams();

                if ($query->execute()) {
                    /**
                     * Registra o customer_id par uso posterior
                     */
                    $this->setId($this->core->db->lastInsertId());
                }
                if ($this->core->db->commit()) {
                    $return = 'Email criado com sucesso!';
                }
            } else {
                $return = 'Tipo ou email não informado!';
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            $return = 'Ocorreu um problema ao criar o email!';
        }
        return $return;
    }
}

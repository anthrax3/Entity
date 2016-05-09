<?php namespace Entity\Models;

class Telephone
{
    protected $core;
    protected $id;
    protected $type;
    protected $number;
    protected $error = false;

    public function __construct()
    {
        $this->core = DB::getInstance();
        $this->table = 'telephone';
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
     * @param  string $number
     * @return string
     */
    public function createNumber($type = null, $number = null)
    {
        $return = null;
        try {
            if (!empty($type) && $number) {
                $this->core->db->beginTransaction();

                /**
                 * Insere os dados iniciais para criação do cliente
                 * @var PDO
                 */
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->table} SET type = :type, number = :number");

                $query->bindValue(':type', $type);
                $query->bindValue(':number', $number);

                if ($query->execute()) {
                    /**
                     * Registra o customer_id par uso posterior
                     */
                    $this->setId($this->core->db->lastInsertId());
                }
                if ($this->core->db->commit()) {
                    $return = 'Telefone criado com sucesso!';
                }
            } else {
                $return = 'Tipo ou telefone não informado!';
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            $return = 'Ocorreu um problema ao criar o telefone!';
        }
        return $return;
    }
}

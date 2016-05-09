<?php namespace Entity\Models;

class Customer
{
    protected $core;
    protected $id;
    protected $personId;
    protected $personJuridicalId;
    protected $personNaturalId;
    protected $telephoneId;
    protected $emailId;
    protected $addressId;
    protected $userId;
    protected $token;
    protected $blocked;
    protected $blocked_reason;
    protected $status;
    protected $observation;
    protected $address;
    protected $email;
    protected $telephone;
    protected $person;
    protected $error = false;

    public function __construct()
    {
        $this->core = DB::getInstance();
        $this->table = 'customer';
        $this->tablePerson = 'customer_person';
        $this->tablePersonJuridical = 'customer_person_juridical';
        $this->tablePersonNatural = 'customer_person_natural';
        $this->tableTelephone = 'customer_telephone';
        $this->tableEmail = 'customer_email';
        $this->tableAddress = 'customer_address';
        $this->tableUser = 'customer_user';
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

    public function setPersonId($personId = null)
    {
        if (empty($personId)) {
            throw new Exception("Você deve informar o id da pessoa!");
        }
        $this->personId = $personId;
        return $this;
    }

    public function getPersonId()
    {
        return $this->personId;
    }

    public function setPersonJuridicalId($personJuridicalId = null)
    {
        if (empty($personJuridicalId)) {
            throw new Exception("Você deve informar o id da pessoa juridica!");
        }
        $this->personJuridicalId = $personJuridicalId;
        return $this;
    }

    public function getPersonJuridicalId()
    {
        return $this->personJuridicalId;
    }

    public function setPersonNaturalId($personNaturalId = null)
    {
        if (empty($personNaturalId)) {
            throw new Exception("Você deve informar o id da pessoa fisica!");
        }
        $this->personNaturalId = $personNaturalId;
        return $this;
    }

    public function getPersonNaturalId()
    {
        return $this->personNaturalId;
    }

    public function setTelephoneId($telephoneId = null)
    {
        if (empty($telephoneId)) {
            throw new Exception("Você deve informar o id do telefone!");
        }
        $this->telephoneId = $telephoneId;
        return $this;
    }

    public function getTelephoneId()
    {
        return $this->telephoneId;
    }

    public function setEmailId($emailId = null)
    {
        if (empty($emailId)) {
            throw new Exception("Você deve informar o id do email!");
        }
        $this->emailId = $emailId;
        return $this;
    }

    public function getEmailId()
    {
        return $this->emailId;
    }

    public function setAddressId($addressId = null)
    {
        if (empty($addressId)) {
            throw new Exception("Você deve informar o id do endereço!");
        }
        $this->addressId = $addressId;
        return $this;
    }

    public function getAddressId()
    {
        return $this->addressId;
    }

    public function setUserId($userId = null)
    {
        if (empty($userId)) {
            throw new Exception("Você deve informar o id do usuário!");
        }
        $this->userId = $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function checkPrimaryDoc($person = null)
    {
        $check = false;
        if (!empty($person)) {
            $primaryDoc = $person->getPrimaryDoc();
            switch ($person->getType()) {
                case 'juridical':
                    $check = $this->getCustomerPersonJuridical($primaryDoc);
                    break;
                case 'natural':
                default:
                    $check = $this->getCustomerPersonNatural($primaryDoc);
                    break;
            }
            $check = !empty($check);
        }
        return $check;
    }

    public function getCustomerPersonJuridical($primaryDoc = null)
    {
        $sql = "SELECT *
                FROM {$this->tablePersonJuridical} cpj
                WHERE cpj.registration_corporate_taxpayers = :primaryDoc";

        $query = $this->core->db->prepare($sql);
        $query->bindValue(':primaryDoc', $primaryDoc);

        $r = array();
        if ($query->execute()) {
            $r = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        return $r;
    }

    public function getCustomerPersonNatural($primaryDoc = null)
    {
        $sql = "SELECT *
                FROM {$this->tablePersonNatural} cpn
                WHERE cpn.individual_taxpayer_registration = :primaryDoc";

        $query = $this->core->db->prepare($sql);
        $query->bindValue(':primaryDoc', $primaryDoc);

        $r = array();
        if ($query->execute()) {
            $r = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        return $r;
    }

    public function getCustomerEmail($address = null)
    {
        $sql = "SELECT e.*, ce.email_id
                FROM email e
                INNER JOIN customer_email ce ON (ce.email_id = e.id)
                WHERE e.address = :address";

        $query = $this->core->db->prepare($sql);
        $query->bindValue(':address', $address);

        $r = false;
        if ($query->execute()) {
            $r = $query->fetch(PDO::FETCH_ASSOC);
        }

        return $r;
    }

    public function getCustomerUser($userId = null)
    {
        $sql = "SELECT c.*,
                       cu.user_id
                FROM customer c
                INNER JOIN customer_user cu ON (cu.customer_id = c.id)
                WHERE cu.user_id = :userId";

        $query = $this->core->db->prepare($sql);
        $query->bindValue(':userId', $userId);

        $r = false;
        if ($query->execute()) {
            $r = $query->fetch(PDO::FETCH_ASSOC);
        }

        return $r;
    }

    public function getCustomerUserToken($token = null)
    {
        $sql = "SELECT c.*,
                       cu.user_id
                FROM customer c
                INNER JOIN customer_user cu ON (cu.customer_id = c.id)
                WHERE c.token = :token";

        $query = $this->core->db->prepare($sql);
        $query->bindValue(':token', $token);

        $r = false;
        if ($query->execute()) {
            $r = $query->fetch(PDO::FETCH_ASSOC);
        }

        return $r;
    }

    /**
     * Cria o cliente conforme os dados passados
     * @param  object $person
     * @return string
     */
    public function create($person = null)
    {
        try {
            if (!empty($person)) {

                $code = substr(str_shuffle('abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 32);
                $token = sha1($code);
                $status = 1;

                $this->core->db->beginTransaction();

                /**
                 * Insere os dados iniciais para criação do cliente
                 * @var PDO
                 */
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->table} SET code = :code, token = :token, status = :status");

                $query->bindValue(':code', $code);
                $query->bindValue(':token', $token);
                $query->bindValue(':status', $status);

                if ($query->execute()) {
                    /**
                     * Registra o customer_id par uso posterior
                     */
                    $this->setId($this->core->db->lastInsertId());

                    /**
                     * Cria a entidade pessoa
                     */
                    $this->createPerson($person);
                }
                if ($this->core->db->commit()) {
                    return 'Cliente criado com sucesso!';
                }
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao criar o cliente!';
        }
    }

    public function createPerson($person = null)
    {
        $customerId = $this->getId();
        if (!empty($customerId)) {
            $query = $this->core
                          ->db
                          ->prepare("INSERT INTO {$this->tablePerson} SET customer_id = :customerId");
            $query->bindValue(':customerId', $customerId);

            if ($query->execute()) {
                $this->setPersonId($this->core->db->lastInsertId());
                switch ($person->getType()) {
                    case 'juridical':
                        $this->createJuridical($person->juridical);
                        break;
                    case 'natural':
                    default:
                        $this->createNatural($person->natural);
                        break;
                }
            }
        }
    }

    public function createJuridical($juridical = null)
    {
        $personId = $this->getPersonId();
        if (!empty($personId) && !empty($juridical)) {
            $query = $this->core
                          ->db
                          ->prepare("INSERT INTO {$this->tablePersonJuridical}
                                        SET customer_person_id = :customerPersonId,
                                            corporate_name = :firstName,
                                            trading_name = :lastName,
                                            registration_corporate_taxpayers = :primaryDoc,
                                            state_registration = :secundaryDoc");

            $query->bindValue(':customerPersonId', $personId);
            $query->bindValue(':firstName', $juridical->getFirstName());
            $query->bindValue(':lastName', $juridical->getLastName());
            $query->bindValue(':primaryDoc', $juridical->getPrimaryDoc());
            $query->bindValue(':secundaryDoc', $juridical->getSecundaryDoc());

            if ($query->execute()) {
                $this->setPersonJuridicalId($this->core->db->lastInsertId());
            }
        }
    }

    public function createNatural($natural = null)
    {
        $personId = $this->getPersonId();
        if (!empty($personId) && !empty($natural)) {
            $query = $this->core
                          ->db
                          ->prepare("INSERT INTO {$this->tablePersonNatural}
                                        SET customer_person_id = :customerPersonId,
                                            firstname = :firstname,
                                            lastname = :lastname,
                                            individual_taxpayer_registration = :primaryDoc,
                                            identity_document = :secundaryDoc");

            $query->bindValue(':customerPersonId', $personId);
            $query->bindValue(':firstName', $natural->getFirstName());
            $query->bindValue(':lastName', $natural->getLastName());
            $query->bindValue(':primaryDoc', $natural->getPrimaryDoc());
            $query->bindValue(':secundaryDoc', $natural->getSecundaryDoc());

            if ($query->execute()) {
                $this->setPersonNaturalId($this->core->db->lastInsertId());
            }
        }
    }

    public function createTelephone($telephoneId = null)
    {
        try {
            $this->core->db->beginTransaction();

            $customerId = $this->getId();
            if (!empty($customerId) && !empty($telephoneId)) {
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->tableTelephone}
                                            SET customer_id = :customerId,
                                                telephone_id = :telephoneId");

                $query->bindValue(':customerId', $customerId);
                $query->bindValue(':telephoneId', $telephoneId);

                if ($query->execute()) {
                    $this->setTelephoneId($this->core->db->lastInsertId());
                }
                if ($this->core->db->commit()) {
                    return 'Relação cliente e telefone criado!';
                }
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao criar a relação do telefone com o cliente!';
        }
    }

    public function createEmail($emailId = null)
    {
        try {
            $this->core->db->beginTransaction();

            $customerId = $this->getId();
            if (!empty($customerId) && !empty($emailId)) {
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->tableEmail}
                                            SET customer_id = :customerId,
                                                email_id = :emailId");

                $query->bindValue(':customerId', $customerId);
                $query->bindValue(':emailId', $emailId);

                if ($query->execute()) {
                    $this->setEmailId($this->core->db->lastInsertId());
                }
                if ($this->core->db->commit()) {
                    return 'Relação cliente e email criado!';
                }
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao criar a relação do email com o cliente!';
        }
    }

    public function createAddress($addressId = null, $numberId = null, $complementId = null)
    {
        try {
            $this->core->db->beginTransaction();

            $customerId = $this->getId();
            if (!empty($customerId) && !empty($addressId)) {
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->tableAddress}
                                            SET customer_id = :customerId,
                                                address_id = :addressId,
                                                address_number_id = :numberId,
                                                address_complement_id = :complementId");

                $query->bindValue(':customerId', $customerId);
                $query->bindValue(':addressId', $addressId);
                $query->bindValue(':numberId', $numberId);
                $query->bindValue(':complementId', $complementId);

                if ($query->execute()) {
                    $this->setAddressId($this->core->db->lastInsertId());
                }
                if ($this->core->db->commit()) {
                    return 'Relação cliente e endereço criado!';
                }
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao criar a relação do endereço com o cliente!';
        }
    }

    public function createUser($userId = null)
    {
        try {
            $this->core->db->beginTransaction();

            $customerId = $this->getId();
            if (!empty($customerId) && !empty($userId)) {
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->tableUser}
                                            SET customer_id = :customerId,
                                                user_id = :userId");

                $query->bindValue(':customerId', $customerId);
                $query->bindValue(':userId', $userId);

                if ($query->execute()) {
                    $this->setUserId($this->core->db->lastInsertId());
                }
                if ($this->core->db->commit()) {
                    return 'Relação cliente e usuário criada!';
                }
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao criar a relação do usuário com o cliente!';
        }
    }

    public function find($customerId = null)
    {
        try {
            $customer = null;
            if (!empty($customerId)) {
                $this->core->db->beginTransaction();

                $query = $this->core->db->prepare(
                    "SELECT
                          -- Customer
                           c.*,
                           -- Person
                          IF ( cpj.id,
                            cpj.corporate_name,
                            cpn.firstname
                          ) AS firstName,
                          IF ( cpj.id,
                            cpj.trading_name,
                            cpn.lastname
                          ) AS lastName,
                          IF ( cpj.id,
                            cpj.registration_corporate_taxpayers,
                            cpn.individual_taxpayer_registration
                          ) AS primaryDoc,
                          IF ( cpj.id,
                            cpj.state_registration,
                            cpn.identity_document
                          ) AS secundaryDoc,
                          -- Email
                           e.type AS emailType,
                           e.address AS emailAddress,
                           -- Telephone
                           t.type AS telephoneType,
                           t.number AS telephoneNumber,
                           -- Address
                           a.type AS addressType,
                           a.street,
                           an.type AS addressNumberType,
                           an.number,
                           ac.type AS addressComplementType,
                           ac.complement,
                           a.zonecode AS zoneCode,
                           s.name AS suburb,
                           city.name AS city,
                           zone.code AS zone,
                           country.name AS country
                        FROM customer c
                          -- Person
                          INNER JOIN customer_person cp ON (cp.customer_id = c.id)
                            LEFT JOIN customer_person_juridical cpj ON (cpj.customer_person_id = cp.id)
                            LEFT JOIN customer_person_natural cpn ON (cpn.customer_person_id = cp.id)

                          -- Email
                          LEFT JOIN customer_email ce ON (ce.customer_id = c.id)
                            LEFT JOIN email e ON (e.id = ce.email_id)

                          -- Telephone
                          LEFT JOIN customer_telephone ct ON (ct.customer_id = c.id)
                            LEFT JOIN telephone t ON (t.id = ct.telephone_id)

                          -- Address
                          LEFT JOIN customer_address ca ON (ca.customer_id = c.id)
                            LEFT JOIN address a ON (a.id = ca.address_id)
                            LEFT JOIN address_number an ON (an.id = ca.address_number_id)
                            LEFT JOIN address_complement ac ON (ac.id = ca.address_complement_id)
                            LEFT JOIN suburb s ON (s.id = a.suburb_id)
                            LEFT JOIN city ON (city.id = a.city_id)
                            LEFT JOIN zone ON (zone.id = a.zone_id)
                            LEFT JOIN country ON (country.id = a.country_id)
                        WHERE c.id = :customerId
                    ;"
                );

                $query->bindValue('customerId', $customerId);

                //$query->debugDumpParams();
                if ($query->execute()) {
                    $customer = $query->fetch(PDO::FETCH_ASSOC);
                    $this->core->db->commit();
                }
            }
            return $customer;
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao buscar o cliente!';
        }
    }
}

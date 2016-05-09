<?php namespace Entity\Models;

class Address
{
    protected $core;
    protected $id;
    protected $suburbId;
    protected $cityId;
    protected $zoneId;
    protected $countryId;
    protected $numberId;
    protected $complementId;
    protected $type;
    protected $street;
    protected $zoneCode;
    protected $error = false;

    public function __construct()
    {
        $this->core = DB::getInstance();
        $this->table = 'address';
        $this->tableComplement = 'address_complement';
        $this->tableNumber = 'address_number';
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

    public function setSuburbId($suburbId = null)
    {
        if (empty($suburbId)) {
            throw new Exception("Você deve informar o Person ID!");
        }
        $this->suburbId = $suburbId;
        return $this;
    }

    public function getSuburbId()
    {
        return $this->suburbId;
    }

    public function setCityId($cityId = null)
    {
        if (empty($cityId)) {
            throw new Exception("Você deve informar o Person ID!");
        }
        $this->cityId = $cityId;
        return $this;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setZoneId($zoneId = null)
    {
        if (empty($zoneId)) {
            throw new Exception("Você deve informar o Person ID!");
        }
        $this->zoneId = $zoneId;
        return $this;
    }

    public function getZoneId()
    {
        return $this->zoneId;
    }

    public function setCountryId($countryId = null)
    {
        if (empty($countryId)) {
            throw new Exception("Você deve informar o Person ID!");
        }
        $this->countryId = $countryId;
        return $this;
    }

    public function getCountryId()
    {
        return $this->countryId;
    }

    public function setNumberId($numberId = null)
    {
        if (empty($numberId)) {
            throw new Exception("Você deve informar o Person ID!");
        }
        $this->numberId = $numberId;
        return $this;
    }

    public function getNumberId()
    {
        return $this->numberId;
    }

    public function setComplementId($complementId = null)
    {
        if (empty($complementId)) {
            throw new Exception("Você deve informar o Person ID!");
        }
        $this->complementId = $complementId;
        return $this;
    }

    public function getComplementId()
    {
        return $this->complementId;
    }

    public function getCities($zoneId = null)
    {
        try {
            $this->core->db->beginTransaction();

            $sql = "SELECT * FROM city";
            if (!empty($zoneId)) {
                $sql .= " WHERE zone_id = :zoneId";
            }

            $query = $this->core->db->prepare($sql);

            if (!empty($zoneId)) {
                $query->bindValue('zoneId', $zoneId);
            }

            //$query->debugDumpParams();

            $cities = array();
            if ($query->execute()) {
                $cities = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            if ($this->core->db->commit()) {
                return $cities;
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao buscar as cidades!';
        }
    }

    public function getZones($countryId = null)
    {
        try {
            $this->core->db->beginTransaction();

            $sql = "SELECT * FROM zone";
            if (!empty($countryId)) {
                $sql .= " WHERE country_id = :countryId";
            }

            $query = $this->core->db->prepare($sql);

            if (!empty($countryId)) {
                $query->bindValue('countryId', $countryId);
            }

            $zones = array();
            if ($query->execute()) {
                $zones = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            if ($this->core->db->commit()) {
                return $zones;
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao buscar as cidades!';
        }
    }

    /*
    public function getAddressByZoneCode($zoneCode)
    {
        $zoneCode = filter_var($zoneCode, FILTER_SANITIZE_NUMBER_INT);
        $json = array(
            'valid' => false,
            'zoneCode'=> $zoneCode
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://viacep.com.br/ws/{$zoneCode}/json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "callback=completeAddress");

        $result = curl_exec($ch);
        curl_close($ch);
    }
    */

    /**
     * Cria o endereço conforme os dados passados
     * @param  object $person
     * @return string
     */
    public function create($address = null)
    {
        try {
            if (!empty($address)) {

                $this->createSuburb($address->getCity(), $address->getSuburb());
                $suburbId = $this->getSuburbId();
                if (empty($suburbId)) {
                    return 'Ocorreu um problema ao cadastrar o bairro!';
                }

                $this->core->db->beginTransaction();

                /**
                 * Verifica se o endereço já existe
                 * @var object
                 */
                // $query = $this->core->db->prepare(
                //     "SELECT * FROM suburb
                //         WHERE suburb_id = :suburbId
                //             AND city_id = :cityId,
                //             AND zone_id = :zoneId,
                //             AND country_id = :countryId,
                //             AND type = :type,
                //             AND street = :street,
                //             AND zonecode = :zonecode");

                // $query->bindValue('cityId', $cityId);
                // $query->bindValue('name', $name);

                // $suburb = null;
                // if ($query->execute()) {
                //     $suburb = $query->fetch(PDO::FETCH_ASSOC);
                // }

                /**
                 * Insere os dados iniciais para criação do cliente
                 * @var PDO
                 */
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO {$this->table}
                                            SET suburb_id = :suburbId,
                                            city_id = :cityId,
                                            zone_id = :zoneId,
                                            country_id = :countryId,
                                            type = :type,
                                            street = :street,
                                            zonecode = :zonecode");

                $query->bindValue('suburbId', $suburbId);
                $query->bindValue('cityId', $address->getCity());
                $query->bindValue('zoneId', $address->getZone());
                $query->bindValue('countryId', $address->getCountry());
                $query->bindValue('type', $address->getType());
                $query->bindValue('street', $address->getStreet());
                $query->bindValue('zonecode', $address->getZoneCode());

                if ($query->execute()) {
                    /**
                     * Registra o address_id para uso posterior
                     */
                    $this->setId($this->core->db->lastInsertId());

                    /**
                     * Insere o numero do endereço
                     */
                    $this->createNumber(null, $address->getNumber());

                    /**
                     * Insere o complemento do endereço
                     */
                    $this->createComplement(null, $address->getComplement());
                }
                if ($this->core->db->commit()) {
                    return 'Endereço criado com sucesso!';
                }
            }
        } catch (\PDOException $e) {
            $this->core->db->rollBack();
            $this->error = true;
            return 'Ocorreu um problema ao cadastrar o endereço!';
        }
    }

    public function createSuburb($cityId = null, $name = null)
    {
        $query = $this->core->db->prepare("SELECT * FROM suburb WHERE city_id = :cityId AND name = :name");

        $query->bindValue('cityId', $cityId);
        $query->bindValue('name', $name);

        $suburb = null;
        if ($query->execute()) {
            $suburb = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($suburb)) {
            $this->setSuburbId($suburb['id']);
        } else {
            if (!empty($cityId) && !empty($name)) {
                $query = $this->core
                              ->db
                              ->prepare("INSERT INTO suburb
                                            SET city_id = :cityId,
                                                name = :name");

                $query->bindValue(':cityId', $cityId);
                $query->bindValue(':name', $name);

                if ($query->execute()) {
                    $this->setSuburbId($this->core->db->lastInsertId());
                }
            }
        }
    }

    public function createNumber($type = null, $number = null)
    {
        $addressId = $this->getId();
        if (!empty($addressId) && !empty($number)) {
            $query = $this->core
                          ->db
                          ->prepare("INSERT INTO {$this->tableNumber}
                                        SET address_id = :addressId,
                                            type = :type,
                                            number = :number");

            $query->bindValue(':addressId', $addressId);
            $query->bindValue(':type', $type);
            $query->bindValue(':number', $number);

            if ($query->execute()) {
                $this->setNumberId($this->core->db->lastInsertId());
            }
        }
    }

    public function createComplement($type = null, $complement = null)
    {
        $addressId = $this->getId();
        if (!empty($addressId) && !empty($complement)) {
            $query = $this->core
                          ->db
                          ->prepare("INSERT INTO {$this->tableComplement}
                                        SET address_id = :addressId,
                                            type = :type,
                                            complement = :complement");

            $query->bindValue(':addressId', $addressId);
            $query->bindValue(':type', $type);
            $query->bindValue(':complement', $complement);

            if ($query->execute()) {
                $this->setComplementId($this->core->db->lastInsertId());
            }
        }
    }
}

<?php namespace Entity\Address;

use \UnexpectedValueException as Argument;
use Entity\Address\AddressInterface;

/**
 * Classe para criação da entidade Endereço
 * @author Ramon Barros
 * @package Address
 * @category entity.address.address
 */
abstract class AbstractAddress implements AddressInterface
{
    protected $id;
    protected $mask;
    protected $type;
    protected $street;
    protected $numberId;
    protected $number;
    protected $complementId;
    protected $complement;
    protected $suburbId;
    protected $suburb;
    protected $cityId;
    protected $city;
    protected $zoneCode;
    protected $zoneId;
    protected $zone;
    protected $countryId;
    protected $country;

    /**
     * Seta o id do endereço
     * @param integer $id
     * @return Address
     */
    public function setId($id = null)
    {
        if (is_null($id)) {
            throw new Argument("Você deve informar o id do endereço.");
        }
        $this->id = $id;
        return $this;
    }

    /**
     * Seta o tipo de endereço (comercial, residencial, etc)
     * @param boolean $type
     * @return Address
     */
    public function setType($type = false)
    {
        if (is_null($type)) {
            throw new Argument("Você deve informar o tipo de endereço.");
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Seta retorno do zoneCode com máscara
     * @param boolean $mask
     * @return Address
     */
    public function setMask($mask = false)
    {
        $this->mask = $mask;
        return $this;
    }

    /**
     * Registra a Rua do endereço
     * @param string $street
     * @return Address
     */
    public function setStreet($street = null)
    {
        if (is_null($street)) {
            throw new Argument("Você deve informar a rua.");
        }
        $this->street = $street;
        return $this;
    }

    /**
     * Registra o id do numero
     * @param string $numberId
     * @return Address
     */
    public function setNumberId($numberId = null)
    {
        if (is_null($numberId)) {
            throw new Argument("Você deve informar o id do numero.");
        }
        $this->numberId = $numberId;
        return $this;
    }

    /**
     * Registra o numero do endereço
     * @param string $number
     * @return Address
     */
    public function setNumber($number = null)
    {
        if (is_null($number)) {
            throw new Argument("Você deve informar o numero.");
        }
        $this->number = $number;
        return $this;
    }

    /**
     * Registra o id do complemento
     * @param string $complementId
     * @return Address
     */
    public function setComplementId($complementId = null)
    {
        if (is_null($complementId)) {
            throw new Argument("Você deve informar o id do complemento.");
        }
        $this->complementId = $complementId;
        return $this;
    }

    /**
     * Registra o complemento do Endereço
     * @param string $complement
     * @return Address
     */
    public function setComplement($complement = null)
    {
        if (is_null($complement)) {
            throw new Argument("Você deve informar o complemento.");
        }
        $this->complement = $complement;
        return $this;
    }

    /**
     * Registra o id do bairro
     * @param string $suburbId
     * @return Address
     */
    public function setSuburbId($suburbId = null)
    {
        if (is_null($suburbId)) {
            throw new Argument("Você deve informar o id do bairro.");
        }
        $this->suburbId = $suburbId;
        return $this;
    }

    /**
     * Registra o bairro do endereço
     * @param string $suburb
     * @return Address
     */
    public function setSuburb($suburb = null)
    {
        if (is_null($suburb)) {
            throw new Argument("Você deve informar o bairro.");
        }
        $this->suburb = $suburb;
        return $this;
    }

    /**
     * Registra o id da cidade
     * @param string $cityId
     * @return Address
     */
    public function setCityId($cityId = null)
    {
        if (is_null($cityId)) {
            throw new Argument("Você deve informar o id da cidade.");
        }
        $this->cityId = $cityId;
        return $this;
    }

    /**
     * Registra a cidade do endereço
     * @param string $city
     * @return Address
     */
    public function setCity($city = null)
    {
        if (is_null($city)) {
            throw new Argument("Você deve informar a cidade.");
        }
        $this->city = $city;
        return $this;
    }

    /**
     * Registra o cep do endereço
     * @param string $zoneCode
     * @return Address
     */
    public function setZoneCode($zoneCode = null)
    {
        if (is_null($zoneCode)) {
            throw new Argument("Você deve informar o cep.");
        }
        $this->zoneCode = $this->onlynumber($zoneCode);
        return $this;
    }

    /**
     * Registra o id do estado
     * @param string $zoneId
     * @return Address
     */
    public function setZoneId($zoneId = null)
    {
        if (is_null($zoneId)) {
            throw new Argument("Você deve informar o id do estado.");
        }
        $this->zoneId = $zoneId;
        return $this;
    }

    /**
     * Registra o estado do endereço
     * @param string $zone
     * @return Address
     */
    public function setZone($zone = null)
    {
        if (is_null($zone)) {
            throw new Argument("Você deve informar o estado.");
        }
        $this->zone = $zone;
        return $this;
    }

    /**
     * Registra o id do país
     * @param string $countryId
     * @return Address
     */
    public function setCountryId($countryId = null)
    {
        if (is_null($countryId)) {
            throw new Argument("Você deve informar o id do país.");
        }
        $this->countryId = $countryId;
        return $this;
    }

    /**
     * Registra o país do endereço
     * @param string $country
     * @return Address
     */
    public function setCountry($country = null)
    {
        if (is_null($country)) {
            throw new Argument("Você deve informar o país.");
        }
        $this->country = $country;
        return $this;
    }

    /**
     * Retorna o id do endereço
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retorna o tipo de endereço
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Retorna se a máscara esta ativa
     * @return boolean
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * Recupera a Rua do endereço
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Recupera o id do numero
     * @return integer
     */
    public function getNumberId()
    {
        return $this->numberId;
    }

    /**
     * Recupera o numero do endereço
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Recupera o id do complemento
     * @return integer
     */
    public function getComplementId()
    {
        return $this->complementId;
    }

    /**
     * Recupera o complemento do endereço
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Recupera o id do bairro
     * @return integer
     */
    public function getSuburbId()
    {
        return $this->suburbId;
    }

    /**
     * Recupera o bairro do endereço
     * @return string
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * Recupera o id cidade
     * @return integer
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Recupera a cidade do endereço
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Recupera o código (cep) do endereço
     * @return string
     */
    public function getZoneCode()
    {
        return $this->zoneCode;
    }

    /**
     * Recupera o id do estado
     * @return integer
     */
    public function getZoneId()
    {
        return $this->zoneId;
    }

    /**
     * Recupera o estado do endereço
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Recupera o id do país
     * @return integer
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Recupera o país
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Recupera somente numeros de uma string
     * @param  string $string
     * @return int
     */
    public function onlynumber($string)
    {
        return preg_replace('/\D/', '', $string);
    }
}

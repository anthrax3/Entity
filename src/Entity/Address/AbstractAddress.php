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

    protected $mask;
    protected $street;
    protected $number;
    protected $complement;
    protected $suburb;
    protected $city;
    protected $zoneCode;
    protected $zone;
    protected $country;

    /**
     * Seta retorno do zoneCode com máscara
     * @param boolean $mask
     */
    public function setMask($mask = false)
    {
        $this->mask = $mask;
        return $this;
    }

    /**
     * Registra a Rua do endereço
     * @param string $street
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
     * Registra o numero do endereço
     * @param string $number
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
     * Registra o complemento do Endereço
     * @param string $complement
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
     * Registra o bairro do endereço
     * @param string $suburb
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
     * Registra a cidade do endereço
     * @param string $city
     */
    public function setCity($city = null)
    {
        if (is_null($city)) {
            throw new Argument("Você deve informar o cidade.");
        }
        $this->city = $city;
        return $this;
    }

    /**
     * Registra o cep do endereço
     * @param string $zoneCode
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
     * Registra o estado do endereço
     * @param string $zone
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
     * Registra o país do endereço
     * @param string $zone
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
     * Recupera o numero do endereço
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
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
     * Recupera o bairro do endereço
     * @return string
     */
    public function getSuburb()
    {
        return $this->suburb;
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
     * Recupera o estado do endereço
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
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

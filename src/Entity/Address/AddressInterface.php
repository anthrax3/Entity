<?php namespace Entity\Address;

/**
 * Interface para criação da entidade Endereco
 * @abstract
 * @author Ramon Barros
 * @package Address
 * @category cadastro
 */
interface AddressInterface
{
    public function setType($type = null);
    public function setStreet($street = null);
    public function setNumber($number = null);
    public function setComplement($complement = null);
    public function setSuburbId($suburbId = null);
    public function setSuburb($suburb = null);
    public function setCityId($cityId = null);
    public function setCity($city = null);
    public function setZoneId($zoneId = null);
    public function setZone($zone = null);
    public function setZoneCode($zoneCode = null);
    public function setCountryId($country = null);
    public function setCountry($country = null);

    public function getType();
    public function getStreet();
    public function getNumber();
    public function getComplement();
    public function getSuburbId();
    public function getSuburb();
    public function getCityId();
    public function getCity();
    public function getZoneId();
    public function getZone();
    public function getZoneCode();
    public function getCountry();
    public function getCountryId();
}

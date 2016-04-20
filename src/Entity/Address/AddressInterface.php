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
    public function setStreet($street = null);
    public function setNumber($number = null);
    public function setComplement($complement = null);
    public function setSuburb($suburb = null);
    public function setCity($city = null);
    public function setZone($zone = null);
    public function setZoneCode($zoneCode = null);
    public function setCountry($country = null);

    public function getStreet();
    public function getNumber();
    public function getComplement();
    public function getSuburb();
    public function getCity();
    public function getZone();
    public function getZoneCode();
    public function getCountry();
}

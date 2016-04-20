<?php namespace Entity;

use Entity\Address\AbstractAddress;

/**
 * Classe para criação da entidade Pessoa Fisica
 * @author Ramon Barros
 * @package Entity
 * @category cadastro
 */
class Address extends AbstractAddress
{

    public function __construct()
    {
        $this->setMask(false);
    }

    public function getZoneCode()
    {
        $zoneCode = parent::getZoneCode();
        if ($this->getMask()) {
            return preg_replace('/^([\d]{5})([\d]{3})$/', '${1}-${2}', $zoneCode);
        }
        return $zoneCode;
    }
}

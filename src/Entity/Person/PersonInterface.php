<?php namespace Entity\Person;

/**
 * Interface para criação da entidade Pessoa
 * @abstract
 * @author Ramon Barros
 * @package Pessoa
 * @category cadastro
 */
interface PersonInterface
{

    const NATURAL = 1;
    const JURIDICAL = 2;

    public function setType($type = null);
    public function setPrimaryDocLength($length = null);
    public function setPrimaryDoc($primaryDoc = null);
    public function setSecundaryDocLength($length = null);
    public function setSecundaryDoc($secundaryDoc = null);
    public function setFirstName($firstName = null);
    public function setLastName($lastName = null);

    public function getType();
    public function getPrimaryDoc();
    public function getSecundaryDoc();
    public function getFirstName();
    public function getLastName();
    public function validatePrimaryDoc();
    public function validateSecundaryDoc();
}

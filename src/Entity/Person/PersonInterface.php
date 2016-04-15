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
    public function setName($name = null);

    public function getType();
    public function getPrimaryDoc();
    public function getSecundaryDoc();
    public function getName();
    public function validatePrimaryDoc();
    public function validateSecundaryDoc();
}

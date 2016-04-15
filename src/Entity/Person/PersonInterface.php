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

    const FISICA = 1;
    const JURIDICA = 2;

    public function getDoc1();
    public function getDoc2();
    public function getName();
    public function getType();

    public function setDoc1($doc1 = null);
    public function setDoc2($doc2 = null);
    public function setName($name = null);
}

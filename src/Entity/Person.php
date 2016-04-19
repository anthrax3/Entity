<?php namespace Entity;

/**
 * Pessoa
 *
 * @package     Pessoa
 * @category    cadastro
 * @author      Ramon Barros
 * @copyright   Copyright (c) 2012, Ramon Barros.
 * @license     http://www.ramon-barros.com/
 * @link        http://public.ramon-barros.com/
 * @since       Version 1.0
 * @filesource  Pessoa.php
 */

use Entity\Person\Natural;
use Entity\Person\Juridical;
use \Exception;

/**
 * Classe para retornar os dados da entidade Pessoa Fisica ou Juridica
 * @abstract
 * @author Ramon Barros
 * @package Entity
 * @category cadastro
 */
class Person
{

    protected $error;
    protected $type;
    public $natural;
    public $juridical;

    public function __construct($doc = null)
    {
        try {
            if (is_null($doc)) {
                throw new Exception("Voc&ecirc; deve informar o documento (CNPJ/CPF).");
            }

            /**
             * Retorna somente numeros
             * @var integer
             */
            $doc = preg_replace('/\D/', '', $doc);

            /**
             * Verifica se o documento é um CPF
             */
            if (strlen($doc)==11) {
                /**
                 * Insere o tipo de pessoa na classe Pessoa.
                 */
                $this->natural = new Natural();
                $this->natural->setPrimaryDocLength(11);

                /**
                 * Insere o documento CPF
                 * @var mixed se o retorno for uma instancia de Pessoa Fisica continua
                 * caso contrário mostra o erro.
                 */
                $this->natural->setPrimaryDoc($doc);
                $this->type = $this->natural->getType();
            } elseif (strlen($doc)==14) {
                /**
                 * Insere o tipo de pessoa na classe Pessoa.
                 */
                $this->juridical = new Juridical();
                $this->juridical->setPrimaryDocLength(14);

                /**
                 * Insere o documento CNPJ
                 * @var mixed se o retorno for uma instancia de Pessoa Juridica continua
                 * caso contrário mostra o erro.
                 */
                $this->juridical->setPrimaryDoc($doc);
                $this->type = $this->juridical->getType();
            } else {
                throw new Exception('Documento n&acirc;o identificado.');
            }

            $this->error = new \stdClass;
            $this->error->status = false;
            $this->error->msg = '';
        } catch (Exception $e) {
            $this->error = new \stdClass;
            $this->error->status = true;
            $this->error->msg = $e->getMessage();
        }
    }

    public function setMask($mask = false)
    {
        $this->{$this->getType()}->setMask($mask);
        return $this;
    }

    public function setPrimaryDoc($primaryDoc = null)
    {
        return $this->{$this->getType()}->setPrimaryDoc($primaryDoc);
    }

    public function setSecundaryDoc($secundaryDoc = null)
    {
        return $this->{$this->getType()}->setSecundaryDoc($secundaryDoc);
    }

    public function setFirstName($firstName = false)
    {
        $this->{$this->getType()}->setFirstName($firstName);
        return $this;
    }

    public function setLastName($lastName = false)
    {
        $this->{$this->getType()}->setLastName($lastName);
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getType()
    {
        if ($this->type == 1) {
            $type = 'natural';
        } else if ($this->type == 2) {
            $type = 'juridical';
        } else {
            throw new Exception('Tipo e pessoa não definido.');
        }
        return $type;
    }

    public function getFirstName()
    {
        return $this->{$this->getType()}->getFirstName();
    }

     public function getLastName()
    {
        return $this->{$this->getType()}->getLastName();
    }

    public function getPrimaryDoc()
    {
        return $this->{$this->getType()}->getPrimaryDoc();
    }

    public function getSecundaryDoc()
    {
        return $this->{$this->getType()}->getSecundaryDoc();
    }
}

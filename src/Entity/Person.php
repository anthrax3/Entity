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

    public function __construct($doc=null)
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

                /**
                 * Insere o documento CPF
                 * @var mixed se o retorno for uma instancia de Pessoa Fisica continua
                 * caso contrário mostra o erro.
                 */
                $this->natural->setCpf($doc);
                $this->type = $this->natural->getType();
            } elseif (strlen($doc)==14) {
                /**
                 * Insere o tipo de pessoa na classe Pessoa.
                 */
                $this->juridical = new Juridical();

                /**
                 * Insere o documento CNPJ
                 * @var mixed se o retorno for uma instancia de Pessoa Juridica continua
                 * caso contrário mostra o erro.
                 */
                $this->juridical->setCnpj($doc);
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
        $instance = null;
        if ($this->type ==1) {
            $instance = $this->natural->setMask($mask);
        } elseif ($this->type == 2) {
            $instance = $this->juridical->setMask($mask);
        }
        return $instance;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getType()
    {
        $type = null;
        if ($this->type == 1) {
            $type = 'natural';
        } else if ($this->type == 2) {
            $type = 'juridical';
        }
        return $type;
    }

    public function getName()
    {
        $name = null;
        if ($this->type == 1) {
            $name = $this->natural->getName();
        } elseif ($this->type==2) {
            $name = $this->juridical->getName();
        }
        return $name;
    }

    public function getDoc1($mask = false)
    {
        $doc1 = null;
        if ($this->type == 1) {
            $mask = !$mask ? $this->natural->getMask() : $mask;
            $doc1 = $this->natural->setMask($mask)->getCpf();
        } elseif ($this->type == 2) {
            $mask = !$mask ? $this->juridical->getMask() : $mask;
            $doc1 = $this->juridical->setMask($mask)->getCnpj();
        }
        return $doc1;
    }

    public function getDoc2()
    {
        $doc2 = null;
        if ($this->type == 1) {
            $doc2 = $this->natural->getRg();
        } elseif ($this->type == 2) {
            $doc2 = $this->juridical->getIe();
        }
        return $doc2;
    }
}

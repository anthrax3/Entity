<?php namespace Entity\Person;

use \UnexpectedValueException as Argument;

/**
 * Classe para criação da entidade Pessoa Fisica e Juridica
 * @abstract
 * @author Ramon Barros
 * @package Cliente
 * @category cadastro
 */
abstract class AbstractPerson implements PersonInterface
{
    protected $doc1;
    protected $doc2;
    protected $name;
    protected $type;

    public function setDoc1($doc1 = null)
    {
        if (is_null($doc1)) {
            throw new Argument("Você deve informar um documento.");
        }
        $this->doc1 = $this->onlynumber($doc1);
        return $this;
    }

    public function setDoc2($doc2 = null)
    {
        if (is_null($doc2)) {
            throw new Argument("Você deve informar um documento.");
        }
        $this->doc2 = $this->onlynumber($doc2);
        return $this;
    }

    public function setName($name = null)
    {
        if (is_null($name)) {
            throw new Argument("Você deve informar um nome.");
        }
        $this->name = $name;
        return $this;
    }

    public function getDoc1()
    {
        return $this->doc1;
    }

    public function getDoc2()
    {
        return $this->doc2;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
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

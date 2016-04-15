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
    protected $primaryDocLength;
    protected $primaryDoc;
    protected $secundaryDoc;
    protected $secundaryDocLength;
    protected $name;
    protected $type;

    public function setType($type = null)
    {
         if (is_null($type)) {
            throw new Argument("Você deve informar o tipo de pessoa.");
        }
        if (is_int($type)) {
            $this->type = $type;
        } else {
            throw new UnexpectedValueException( sprintf( 'O valor do tipo deve ser numérico, %s foi dado.' , gettype( $type ) ) );
        }
        return $this;
    }

    public function setPrimaryDocLength($primaryDocLength = null)
    {
        if (is_null($primaryDocLength)) {
            throw new Argument("Você deve informar o tamanho do documento principal.");
        }
        $this->primaryDocLength = $primaryDocLength;
        return $this;
    }

    public function setPrimaryDoc($primaryDoc = null)
    {
        if (is_null($primaryDoc)) {
            throw new Argument("Você deve informar um documento principal.");
        }
        $this->primaryDoc = $this->onlynumber($primaryDoc);
        return $this;
    }

    public function setSecundaryDocLength($secundaryDocLength = null)
    {
        if (is_null($secundaryDocLength)) {
            throw new Argument("Você deve informar o tamanho do documento secundário.");
        }
        $this->secundaryDocLength = $secundaryDocLength;
        return $this;
    }

    public function setSecundaryDoc($secundaryDoc = null)
    {
        if (is_null($secundaryDoc)) {
            throw new Argument("Você deve informar um documento secundário.");
        }
        $this->secundaryDoc = $this->onlynumber($secundaryDoc);
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

    public function getType()
    {
        return $this->type;
    }

    public function getPrimaryDocLength()
    {
        return $this->primaryDocLength;
    }

    public function getPrimaryDoc()
    {
        return $this->primaryDoc;
    }

    public function getSecundaryDoclength()
    {
        return $this->secundaryDocLength;
    }

    public function getSecundaryDoc()
    {
        return $this->secundaryDoc;
    }

    public function getName()
    {
        return $this->name;
    }

    public function validatePrimaryDoc()
    {
        return strlen($this->primaryDoc) === $this->primaryDocLength;
    }

    public function validateSecundaryDoc()
    {
        return strlen($this->secundaryDoc) === $this->secundaryDocLength;
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

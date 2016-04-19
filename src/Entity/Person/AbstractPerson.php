<?php namespace Entity\Person;

use \UnexpectedValueException as Argument;
use Entity\Person\Exceptions\PrimaryDocInvalidException;
use Entity\Person\Exceptions\SecundaryDocInvalidException;

/**
 * Classe para criação da entidade Pessoa Fisica e Juridica
 * @abstract
 * @author Ramon Barros
 * @package Cliente
 * @category cadastro
 */
abstract class AbstractPerson implements PersonInterface
{
    protected $mask;
    protected $primaryDocLength;
    protected $primaryDoc;
    protected $secundaryDoc;
    protected $secundaryDocLength;
    protected $firstName;
    protected $lastName;
    protected $type;

    public function setType($type = null)
    {
         if (is_null($type)) {
            throw new Argument("Você deve informar o tipo de pessoa.");
        }
        if (is_int($type)) {
            $this->type = $type;
        } else {
            throw new Argument( sprintf( 'O valor do tipo deve ser numérico, %s foi dado.' , gettype( $type ) ) );
        }
        return $this;
    }

    public function setMask($mask=false)
    {
        $this->mask = $mask;
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
        if (!$this->validatePrimaryDoc()) {
            throw new PrimaryDocInvalidException();
        }
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
        if (!$this->validateSecundaryDoc()) {
            throw new SecundaryDocInvalidException();
        }
        return $this;
    }

    public function setFirstName($firstName = null)
    {
        if (is_null($firstName)) {
            throw new Argument("Você deve informar o primeiro nome.");
        }
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName = null)
    {
        if (is_null($lastName)) {
            throw new Argument("Você deve informar o último nome.");
        }
        $this->lastName = $lastName;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMask()
    {
        return $this->mask;
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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
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

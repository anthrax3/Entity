<?php namespace Entity\Telephone;

use \UnexpectedValueException as Argument;
use Illuminate\Container\Container;

/**
 * Classe para criação da entidade Pessoa Fisica
 * @author Ramon Barros
 * @package Pessoa
 * @category cadastro
 */
class Number extends Container
{
    protected $mask;
    protected $type;

    public function __construct($type = null, $number = null)
    {
        if (!empty($type) && !empty($number)) {
            $this->setMask(false)
                 ->setType($type)
                 ->setNumber($number);
        }
    }

    /**
     * Seta a utilização de mascara no numero
     * @param boolean $mask
     */
    public function setMask($mask = false)
    {
        $this->mask = $mask;
        return $this;
    }

    /**
     * Registra o tipo do numero telefonico
     * @param string $type
     */
    public function setType($type = null)
    {
        if (is_null($type)) {
            throw new Argument("Você deve informar o tipo de telefone.");
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Registra o numero telefonico
     * @param string $number
     */
    public function setNumber($number = null)
    {
        if (is_null($number)) {
            throw new Argument("Você deve informar o numero.");
        }
        $this->instance("{$this->type}", $this->onlynumber($number));
        return $this;
    }

    /**
     * Recupera o tipo de numero telefonico
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Recupera o numero telefonico referente ao tipo informado
     * @param  string $type
     * @return mixed
     */
    public function getNumber($type = null)
    {
        if (is_null($type)) {
            throw new Argument("Antes você deve informar um tipo");
        }
        $number = $this["{$type}"];
        if ($this->mask) {
            return $this->mask($number);
        }
        return $number;
    }

    public function mask($number = null)
    {
        return preg_replace('/^([\d]{2})([\d]{4}[\d]?)([\d]{4})$/', '(${1})${2}-${3}', $number);
    }

    /**
     * Recupera as instancias dos numeros registrados
     * @return object
     */
    public function getNumbers()
    {
        return $this->instances;
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

    /**
     * Dynamically access application services.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this[$key];
    }

    /**
     * Dynamically set application services.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this[$key] = $value;
    }
}

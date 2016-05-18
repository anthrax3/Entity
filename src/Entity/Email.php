<?php namespace Entity;

use \UnexpectedValueException as Argument;
use Illuminate\Container\Container;

/**
 * Classe para criação da entidade Pessoa Fisica
 * @author Ramon Barros
 * @package Pessoa
 * @category cadastro
 */
class Email extends Container
{
    protected $type;

    public function __construct($type = null, $address = null)
    {
        if (!empty($type) && !empty($address)) {
            $this->setType($type)
                 ->setAddress($address);
        }
    }

    /**
     * Registra o tipo do email
     * @param string $type
     */
    public function setType($type = null)
    {
        if (is_null($type)) {
            throw new Argument("Você deve informar o tipo do email.");
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Registra o endereço de email
     * @param string $address
     */
    public function setAddress($address = null)
    {
        if (is_null($address)) {
            throw new Argument("Você deve informar endereço do email.");
        }
        $this->instance($this->type, $address);
        return $this;
    }

    /**
     * Recupera o tipo de email
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Recupera o endereço de email referente ao tipo informado
     * @param  string $type
     * @return mixed
     */
    public function getAddress($type = null)
    {
        if (is_null($type)) {
            throw new Argument("Antes você deve informar um tipo.");
        }
        $address = !empty($this->instances[$type]) ? $this->instances[$type] : null;
        return $address;
    }

    /**
     * Recupera as instancias dos endereços de email registrados
     * @return object
     */
    public function getAddresses()
    {
        return $this->instances;
    }

    /**
     * Dynamically access application services.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->instances[$key];
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
        $this->instance($key, $value);
    }
}

<?php namespace Entity\Pessoa\Exceptions;

use \Exception;

class CnpjInvalidoExpection extends Exception
{
    public function __construct()
    {
        parent::__construct('CNPJ inv&aacute;lido.');
    }
}

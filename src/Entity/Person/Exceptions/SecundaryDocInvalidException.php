<?php namespace Entity\Person\Exceptions;

use \Exception;

class SecundaryDocInvalidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Documento secundário inv&aacute;lido.');
    }
}

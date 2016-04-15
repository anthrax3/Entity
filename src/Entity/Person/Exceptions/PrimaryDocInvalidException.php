<?php namespace Entity\Person\Exceptions;

use \Exception;

class PrimaryDocInvalidException extends Exception
{
    public function __construct()
    {
        parent::__construct('Documento principal inv&aacute;lido.');
    }
}

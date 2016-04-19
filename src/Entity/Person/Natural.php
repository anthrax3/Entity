<?php namespace Entity\Person;

use Entity\Person\AbstractPerson;

/**
 * Classe para criação da entidade Pessoa Fisica
 * @author Ramon Barros
 * @package Person
 * @category cadastro
 */
class Natural extends AbstractPerson
{
    public function __construct()
    {
        $this->setType(self::NATURAL);
        $this->setPrimaryDocLength(11);
        $this->setMask(false);
    }

    public function getPrimaryDoc()
    {
        $primaryDoc = parent::getPrimaryDoc();
        if ($this->getMask()) {
            $primaryDoc = preg_replace('/^([\d]{3})([\d]{3})([\d]{3})([\d]{2})$/', '${1}.${2}.${3}-${4}', $primaryDoc);
        }
        return $primaryDoc;
    }

    /**
     * Verifica se é um número de CPF válido.
     * @return boolean
     */
    public function validatePrimaryDoc()
    {
        if (!parent::validatePrimaryDoc()) {
            return false;
        }

        $primaryDoc = $this->getPrimaryDoc();
        if (preg_match('/^(\d{1})\1{10}$/', $primaryDoc)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += $primaryDoc[$i] * (10-$i);
        }
        $mod = $sum % 11;
        $digit = ($mod > 1) ? (11 - $mod) : 0;

        if ($primaryDoc[9] != $digit) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $primaryDoc[$i] * (11-$i);
        }
        $mod = $sum % 11;
        $digit = ($mod > 1) ? (11 - $mod) : 0;

        if ($primaryDoc[10] != $digit) {
            return false;
        }
        return true;
    }
}

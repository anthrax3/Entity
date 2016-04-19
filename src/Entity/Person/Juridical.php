<?php namespace Entity\Person;

use Entity\Person\AbstractPerson;

/**
 * Classe para criação da entidade Pessoa Juridica
 * @author Ramon Barros
 * @package Person
 * @category cadastro
 */
class Juridical extends AbstractPerson
{
    protected $corporateName;
    protected $tradingName;

    public function __construct()
    {
        $this->setType(self::JURIDICAL);
        $this->setPrimaryDocLength(14);
        $this->setMask(false);
    }

    public function setFirstName($firstName = null)
    {
        parent::setFirstName($firstName);
        $this->setCorporateName($firstName);
        return $this;
    }

    public function setLastName($lastName = null)
    {
        parent::setLastName($lastName);
        $this->setTradingName($lastName);
        return $this;
    }

    public function setCorporateName($corporateName = null)
    {
        if (is_null($corporateName)) {
            throw new Argument("Você deve informar a razão social.");
        }
        $this->corporateName = $corporateName;
        return $this;
    }

    public function setTradingName($tradingName = null)
    {
        if (is_null($tradingName)) {
            throw new Argument("Você deve informar o nome fantasía.");
        }
        $this->tradingName = $tradingName;
        return $this;
    }

    public function getCorporateName()
    {
        return $this->corporateName;
    }

    public function getTradingName()
    {
        return $this->tradingName;
    }

    public function getPrimaryDoc()
    {
        $primaryDoc = parent::getPrimaryDoc();
        if ($this->mask) {
            $primaryDoc = preg_replace('/^([\d]{2})([\d]{3})([\d]{3})([\d]{4})([\d]{2})$/', '${1}.${2}.${3}/${4}-${5}', $primaryDoc);
        }
        return $primaryDoc;
    }

    /**
     * Verifica se é um número de CNPJ válido.
     * @return boolean
     */
    public function validatePrimaryDoc()
    {
        if (!parent::validatePrimaryDoc()) {
            return false;
        }

        $primaryDoc = $this->getPrimaryDoc();

        if (preg_match('/^(\d{1})\1{13}$/', $primaryDoc)) {
            return false;
        }

        $soma = 0;
        for ($i = 0; $i < 12; $i++) {

            /** verifica qual é o multiplicador. Caso o valor do caracter seja entre 0-3, diminui o valor do caracter por 5
             * caso for entre 4-11, diminui por 13 **/
            $multiplicador = ($i <= 3 ? 5 : 13) - $i;

            $soma += $primaryDoc{$i}
            * $multiplicador;
        }
        $soma = $soma % 11;


        if ($soma == 0 || $soma == 1) {
            $digitoUm=0;
        } else {
            $digitoUm = 11 - $soma;
        }

        if ((int)$digitoUm == (int)$primaryDoc{12}) {
            $soma = 0;

            for ($i = 0; $i < 13; $i++) {

                /** verifica qual é o multiplicador. Caso o valor do caracter seja entre 0-4, diminui o valor do caracter por 6
                 * caso for entre 4-12, diminui por 14 **/
                $multiplicador = ($i <= 4 ? 6 : 14) - $i;
                $soma += $primaryDoc{$i}
                * $multiplicador;
            }
            $soma = $soma % 11;
            if ($soma == 0 || $soma == 1) {
                $digitoDois=0;
            } else {
                $digitoDois = 11 - $soma;
            }
            if ($digitoDois == $primaryDoc{13}) {
                return true;
            }
        }
        return false;
    }
}

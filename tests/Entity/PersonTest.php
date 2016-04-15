<?php namespace Entity;

use Entity\AbstractTest;

/**
* Teste da entidade Pessoa
*
* @category Tests
*
*/
class PersonTest extends AbstractTest
{
    public function assertPreConditions()
    {
        $this->assertTrue(
              class_exists($class = '\Entity\Person'),
              'Class not found: '.$class
      );
    }

    /**
     * expectedException Exception
     * expectedExceptionMessage Voc&ecirc; deve informar o documento (CNPJ/CPF).
     */
    public function testSetWithInvalidDataShouldThrownAnException()
    {
        $instance = new \Entity\Person();
    }

    /**
     * expectedException Exception
     * expectedExceptionMessage Documento n&acirc;o identificado.
     */
    public function testSetWithInvalidDocShouldThrownAnException()
    {
        $instance = new \Entity\Person('0000000000');

        $error = new \stdClass();
        $error->status = true;
        $error->msg = 'Documento n&acirc;o identificado.';
        $this->assertEquals($instance->getError(), $error);
    }

    public function testJuridicalInstantiationWithArgumentsShouldWork()
    {
        $doc1 = '87.408.852/0001-09';
        $instance = new \Entity\Person($doc1);

        $return = $instance->juridical;

        $juridical = new \Entity\Person\Juridical;
        $juridical->setPrimaryDoc($doc1);

        $this->assertEquals($juridical, $return, 'Returned value should be the same instance for fluent interface');
        $this->assertAttributeEquals($return->getPrimaryDoc(), 'primaryDoc', $return, 'Attribute was not correctly set');

        $this->assertEquals($instance->getType(), 'juridical');
        $this->assertEquals($instance->getName(), '');
        $this->assertEquals($instance->getPrimaryDoc(), '87408852000109');
        $this->assertEquals($instance->setMask(true)->getPrimaryDoc(), '87.408.852/0001-09');
        $this->assertEquals($instance->getSecundaryDoc(), '');
    }

    public function testNaturalInstantiationWithArgumentsShouldWork()
    {
        $doc1 = '784.227.150-07';
        $instance = new \Entity\Person($doc1);

        $return = $instance->natural;

        $natural = new \Entity\Person\Natural;
        $natural->setPrimaryDoc($doc1);

        $this->assertEquals($natural, $return, 'Returned value should be the same instance for fluent interface');
        $this->assertAttributeEquals($return->getPrimaryDoc(), 'primaryDoc', $return, 'Attribute was not correctly set');

        $this->assertEquals($instance->getType(), 'natural');
        $this->assertEquals($instance->getName(), '');
        $this->assertEquals($instance->getPrimaryDoc(), '78422715007');
        $this->assertEquals($instance->setMask(true)->getPrimaryDoc(), '784.227.150-07');
        $this->assertEquals($instance->getSecundaryDoc(), '');
    }
}

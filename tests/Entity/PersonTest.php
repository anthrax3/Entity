<?php

use Entity\AbstractTest;

/**
* Teste da entidade Pessoa
*
* @category Tests
*
*/
class PersonTest extends AbstractTest
{
    private $instance;

    public function assertPreConditions()
    {
        $this->assertTrue(
              class_exists($class = 'Entity\\Email'),
              'Class not found: '.$class
        );
        $this->instance = new Entity\Person('87.408.852/0001-09');
    }

    /**
     * expectedException Exception
     * expectedExceptionMessage Voc&ecirc; deve informar o documento (CNPJ/CPF).
     */
    public function testSetWithInvalidDataShouldThrownAnException()
    {
        $instance = new Entity\Person();
    }

    /**
     * expectedException Exception
     * expectedExceptionMessage Tipo e pessoa não definido.
     */
    public function testGetTypeThrownAnException()
    {
        $instance = new Entity\Person('0');
        $instance->getType();
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o primeiro nome.
     */
    public function testSetWithInvalidFirstNameShouldThrownAnException()
    {
        $this->instance->setFirstName( null );
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o último nome.
     */
    public function testSetWithInvalidLastNameShouldThrownAnException()
    {
        $this->instance->setLastName( null );
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar um documento principal.
     */
    public function testSetWithInvalidPrimaryDocShouldThrownAnException()
    {
        $this->instance->setPrimaryDoc( null );
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar um documento secundário.
     */
    public function testSetWithInvalidSecundaryDocShouldThrownAnException()
    {
        $this->instance->setSecundaryDoc( null );
    }

    /**
    * @depends testSetWithInvalidDataShouldThrownAnException
    * @expectedException PrimaryDocInvalidException
    * @expectedExceptionMessage Documento principal inv&aacute;lido.
    */
    public function testSetWithInvalidDataShouldPrimaryDoc()
    {
        $this->setExpectedException('\Entity\Person\Exceptions\PrimaryDocInvalidException');

        $juridical = new Entity\Person\Juridical;
        $juridical->setPrimaryDoc(00000000000000);
    }

    /**
     * expectedException Exception
     * expectedExceptionMessage Documento n&acirc;o identificado.
     */
    public function testSetWithInvalidDocShouldThrownAnException()
    {
        $instance = new Entity\Person('0000000000');

        $error = new \stdClass();
        $error->status = true;
        $error->msg = 'Documento n&acirc;o identificado.';
        $this->assertEquals($instance->getError(), $error);
    }

    public function testJuridicalInstantiationWithArgumentsShouldWork()
    {
        $doc1 = '87.408.852/0001-09';
        $instance = new Entity\Person($doc1);
        $instance->setFirstName('FirstName')
                 ->setLastName('LastName');

        $return = $instance->juridical;

        $juridical = new Entity\Person\Juridical;
        $juridical->setPrimaryDoc($doc1);
        $juridical->setFirstName('FirstName');
        $juridical->setLastName('LastName');

        $this->assertEquals($juridical, $return, 'Returned value should be the same instance for fluent interface');
        $this->assertAttributeEquals($return->getPrimaryDoc(), 'primaryDoc', $return, 'Attribute was not correctly set');

        $this->assertEquals($instance->getType(), 'juridical');
        $this->assertEquals($instance->getFirstName(), 'FirstName');
        $this->assertEquals($instance->getLastName(), 'LastName');
        $this->assertEquals($instance->getPrimaryDoc(), '87408852000109');
        $this->assertEquals($juridical->getPrimaryDocLength(), 14);
        $this->assertEquals($instance->setMask(true)->getPrimaryDoc(), '87.408.852/0001-09');
        $this->assertEquals($instance->getSecundaryDoc(), '');
        $this->assertEquals($juridical->getSecundaryDoclength(), null);
    }

    public function testNaturalInstantiationWithArgumentsShouldWork()
    {
        $doc1 = '784.227.150-07';
        $instance = new Entity\Person($doc1);
        $instance->setFirstName('FirstName')
                 ->setLastName('LastName');

        $return = $instance->natural;

        $natural = new Entity\Person\Natural;
        $natural->setPrimaryDoc($doc1);
        $natural->setFirstName('FirstName');
        $natural->setLastName('LastName');

        $this->assertEquals($natural, $return, 'Returned value should be the same instance for fluent interface');
        $this->assertAttributeEquals($return->getPrimaryDoc(), 'primaryDoc', $return, 'Attribute was not correctly set');

        $this->assertEquals($instance->getType(), 'natural');
        $this->assertEquals($instance->getFirstName(), 'FirstName');
        $this->assertEquals($instance->getLastName(), 'LastName');
        $this->assertEquals($instance->getPrimaryDoc(), '78422715007');
        $this->assertEquals($natural->getPrimaryDocLength(), 11);
        $this->assertEquals($instance->setMask(true)->getPrimaryDoc(), '784.227.150-07');
        $this->assertEquals($instance->getSecundaryDoc(), '');
        $this->assertEquals($natural->getSecundaryDoclength(), null);
    }
}

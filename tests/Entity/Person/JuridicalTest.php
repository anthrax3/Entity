<?php

use Entity\AbstractTest;

/**
* Teste da entidade Pessoa\Juridica
*
* @category Tests
*
*/
class JuridicalTest extends AbstractTest
{
    private $instance;

    public function assertPreConditions()
    {
        // $this->assertTrue(
        //       class_exists($class = 'Entity\Person\Juridical'),
        //       'Class not found: '.$class
        // );
        $this->instance = new \Entity\Person\Juridical();
    }
    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf('\Entity\Person\Juridical', $this->instance);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testStringToNumber()
    {
        $string = '87.408.852/0001-09';
        $comp = $this->instance->onlynumber($string);
        $this->assertEquals( $comp , 87408852000109 );
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testReturnDoc1()
    {
        $return = $this->instance->setPrimaryDoc('87.408.852/0001-09');
        $this->assertEquals( $this->instance->getPrimaryDoc() , 87408852000109 );
        $this->assertEquals($this->instance, $return, 'Returned value should be the same instance for fluent interface');
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testReturnDoc2()
    {
        $return = $this->instance->setSecundaryDocLength(10)->setSecundaryDoc('1234567890');
        $this->assertEquals( $this->instance->getSecundaryDoc() , 1234567890 );
        $this->assertEquals($this->instance, $return, 'Returned value should be the same instance for fluent interface');
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetType()
    {
        $type = $this->instance->getType();
        $this->assertEquals( $type , 2 );
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    * @expectedException UnexpectedValueException
    * @expectedExceptionMessage Você deve informar o tipo de pessoa.
    */
    public function testSetTypeNull()
    {
        $this->instance->setType(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetMask()
    {
        $mask = $this->instance->getMask();
        $this->assertFalse($mask);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar a razão social.
     */
    public function testSetCorporateNameNull()
    {
        $this->instance->setCorporateName(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o nome fantasía.
     */
    public function testSetTradingNameNull()
    {
        $this->instance->setTradingName(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetCorporateName()
    {
        $this->instance->setCorporateName('Corporate Name');
        $corporateName = $this->instance->getCorporateName();
        $this->assertEquals($corporateName, 'Corporate Name');
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetTradingName()
    {
        $this->instance->setTradingName('Tranding Name');
        $tradingName = $this->instance->getTradingName();
        $this->assertEquals($tradingName, 'Tranding Name');
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testShouldExistsSetterForMask()
    {
        $mask = true;
        $return = $this->instance->setMask( $mask );
        $this->assertEquals($this->instance, $return, 'Returned value should be the same instance for fluent interface');
        $this->assertAttributeEquals($mask, 'mask', $this->instance, 'Attribute was not correctly set');
    }

    /**
     * @expectedException PrimaryDocInvalidException
     * @expectedExceptionMessage Documento principal inv&aacute;lido.
     */
    public function testSetWithInvalidPrimaryDocShouldThrownAnException()
    {
        $this->setExpectedException('\Entity\Person\Exceptions\PrimaryDocInvalidException');
        $this->instance->setPrimaryDoc( '1234567890' );
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o tamanho do documento principal.
     */
    public function testSetWithInvalidPrimaryLengthDocShouldThrownAnException()
    {
        $this->instance->setPrimaryDocLength(null);
    }

    /**
     * @expectedException SecundaryDocInvalidException
     * @expectedExceptionMessage Documento principal inv&aacute;lido.
     */
    public function testSetWithInvalidSecundaryDocShouldThrownAnException()
    {
        $this->setExpectedException('\Entity\Person\Exceptions\SecundaryDocInvalidException');
        $this->instance->setSecundaryDoc( '1234567890' );
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o tamanho do documento secundário.
     */
    public function testSetWithInvalidSecundaryLengthDocShouldThrownAnException()
    {
        $this->instance->setSecundaryDocLength(null);
    }
}

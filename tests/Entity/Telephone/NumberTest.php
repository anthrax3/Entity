<?php

use Entity\AbstractTest;

/**
* Teste da entidade Telefone\Numero
*
* @category Tests
*
*/
class NumberTest extends AbstractTest
{
    private $instance;

    public function assertPreConditions()
    {
        // $this->assertTrue(
        //       class_exists($class = 'Entity\Telephone\Number'),
        //       'Class not found: '.$class
        // );
        $this->instance = new \Entity\Telephone\Number('type', '00000000');
    }

    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf('\Entity\Telephone\Number', $this->instance);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o tipo de telefone.
     */
    public function testSetTypeNull()
    {
        $this->instance->setType(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o numero.
     */
    public function testSetNumberNull()
    {
        $this->instance->setNumber(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Antes você deve informar um tipo
     */
    public function testGetNumberTypeNull()
    {
        $this->instance->getNumber(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testStringToNumber()
    {
        $string = '(54)9999-1234';
        $comp = $this->instance->onlynumber($string);
        $this->assertEquals( $comp , 5499991234 );
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetNumberMask()
    {
        $this->instance
             ->setType('number1')
             ->setNumber('5499991234');
        $this->assertEquals( $this->instance->getNumber('number1') , 5499991234 );
        $this->assertEquals( $this->instance->setMask(true)->getNumber('number1') , '(54)9999-1234' );
        $this->assertEquals( $this->instance->number1, '5499991234' );

        // Nono digito
        $this->instance
             ->setType('number2')
             ->setNumber('54999991234');
        $this->assertEquals( $this->instance->setMask(true)->getNumber('number2') , '(54)99999-1234' );
        $this->assertEquals( $this->instance->number2, '54999991234' );

        $this->assertEquals(
            $this->instance->getNumbers(),
            array(
                'type' => '00000000',
                'number1' => '5499991234',
                'number2' => '54999991234'
            )
        );

        $this->instance->number2 = '54999981234';
        $this->assertEquals( $this->instance->setMask(false)->getNumber('number2') , 54999981234 );
    }
}

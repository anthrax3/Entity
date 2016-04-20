<?php

use Entity\AbstractTest;

/**
* Teste da entidade Telefone\Numero
*
* @category Tests
*
*/
class EmailTest extends AbstractTest
{
    private $instance;

    public function assertPreConditions()
    {
        // $this->assertTrue(
        //       class_exists($class = 'Entity\Email'),
        //       'Class not found: '.$class
        // );
        $this->instance = new \Entity\Email('email1', 'admin@admin.com');
    }

    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf('\Entity\Email', $this->instance);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o tipo do email.
     */
    public function testSetTypeNull()
    {
        $this->instance->setType(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar endereço do email.
     */
    public function testSetAddressNull()
    {
        $this->instance->setAddress(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Antes você deve informar um tipo.
     */
    public function testGetAddressTypeNull()
    {
        $this->instance->getAddress(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testGetAddress()
    {
        $this->instance
             ->setType('email2')
             ->setAddress('admin@admin.com.br');
        $this->assertEquals( $this->instance->getAddress('email2') , 'admin@admin.com.br');
        $this->assertEquals( $this->instance->email2, 'admin@admin.com.br' );

        $this->assertEquals(
            $this->instance->getAddresses(),
            array(
                'email1' => 'admin@admin.com',
                'email2' => 'admin@admin.com.br'
            )
        );

        $this->instance->email1 = 'user@user.com';
        $this->assertEquals( $this->instance->getAddress('email1'), 'user@user.com');
    }
}

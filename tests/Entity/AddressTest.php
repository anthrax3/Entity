<?php namespace Entity\Address;

use Entity\AbstractTest;

/**
* Teste da entidade Pessoa\Fisica
*
* @category Tests
*
*/
class AddressTest extends AbstractTest
{
    private $instance;

    public function assertPreConditions()
    {
        $this->assertTrue(
              class_exists($class = 'Entity\Address'),
              'Class not found: '.$class
        );
        $this->instance = new \Entity\Address();
    }

    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf('\Entity\Address', $this->instance);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar a rua.
     */
    public function testSetStreetNull()
    {
        $this->instance->setStreet(null);
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
     * @expectedExceptionMessage Você deve informar o complemento.
     */
    public function testSetComplementNull()
    {
        $this->instance->setComplement(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o bairro.
     */
    public function testSetSuburbNull()
    {
        $this->instance->setSuburb(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o cidade.
     */
    public function testSetCityNull()
    {
        $this->instance->setCity(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o cep.
     */
    public function testSetZoneCodeNull()
    {
        $this->instance->setZoneCode(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o estado.
     */
    public function testSetZoneNull()
    {
        $this->instance->setZone(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o país.
     */
    public function testSetCountryNull()
    {
        $this->instance->setCountry(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testAddressInstantiationWithArgumentsShouldWork()
    {
        $this->instance->setStreet('Street 1')
                       ->setNumber('Number 1')
                       ->setComplement('Complement 1')
                       ->setSuburb('Suburb 1')
                       ->setCity('City 1')
                       ->setZoneCode('99099000')
                       ->setZone('Zone 1')
                       ->setCountry('Country 1');

        $this->assertEquals($this->instance->getStreet(), 'Street 1');
        $this->assertEquals($this->instance->getNumber(), 'Number 1');
        $this->assertEquals($this->instance->getComplement(), 'Complement 1');
        $this->assertEquals($this->instance->getSuburb(), 'Suburb 1');
        $this->assertEquals($this->instance->getCity(), 'City 1');
        $this->assertEquals($this->instance->getZoneCode(), '99099000');
        $this->assertEquals($this->instance->setMask(true)->getZoneCode(), '99099-000');
        $this->assertEquals($this->instance->getZone(), 'Zone 1');
        $this->assertEquals($this->instance->getCountry(), 'Country 1');
    }
}

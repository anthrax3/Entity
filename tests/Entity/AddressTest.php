<?php

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
              class_exists($class = 'Entity\\Address'),
              'Class not found: '.$class
        );
        $this->instance = new Entity\Address();
    }

    public function testInstantiationWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf('Entity\\Address', $this->instance);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o id do endereço.
     */
    public function testSetIdNull()
    {
        $this->instance->setId(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar o tipo de endereço.
     */
    public function testSetTypeNull()
    {
        $this->instance->setType(null);
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
     * @expectedExceptionMessage Você deve informar o id do numero.
     */
    public function testSetNumberIdNull()
    {
        $this->instance->setNumberId(null);
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
     * @expectedExceptionMessage Você deve informar o id do complemento.
     */
    public function testSetComplementIdNull()
    {
        $this->instance->setComplementId(null);
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
     * @expectedExceptionMessage Você deve informar o id do bairro.
     */
    public function testSetSuburbIdNull()
    {
        $this->instance->setSuburbId(null);
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
     * @expectedExceptionMessage Você deve informar o id da cidade.
     */
    public function testSetCityIdNull()
    {
        $this->instance->setCityId(null);
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Você deve informar a cidade.
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
     * @expectedExceptionMessage Você deve informar o id do estado.
     */
    public function testSetZoneIdNull()
    {
        $this->instance->setZoneId(null);
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
     * @expectedExceptionMessage Você deve informar o id do país.
     */
    public function testSetCountryIdNull()
    {
        $this->instance->setCountryId(null);
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
        $this->instance->setId(123)
                       ->setType('Type 1')
                       ->setStreet('Street 1')
                       ->setNumberId(321)
                       ->setNumber('Number 1')
                       ->setComplementId(213)
                       ->setComplement('Complement 1')
                       ->setSuburbId(55)
                       ->setSuburb('Suburb 1')
                       ->setCityId(66)
                       ->setCity('City 1')
                       ->setZoneCode('99099000')
                       ->setZoneId(77)
                       ->setZone('Zone 1')
                       ->setCountryId(88)
                       ->setCountry('Country 1');

        $this->assertEquals($this->instance->getId(), 123);
        $this->assertEquals($this->instance->getType(), 'Type 1');
        $this->assertEquals($this->instance->getStreet(), 'Street 1');
        $this->assertEquals($this->instance->getNumber(), 'Number 1');
        $this->assertEquals($this->instance->getNumberId(), 321);
        $this->assertEquals($this->instance->getComplement(), 'Complement 1');
        $this->assertEquals($this->instance->getComplementId(), 213);
        $this->assertEquals($this->instance->getSuburbId(), 55);
        $this->assertEquals($this->instance->getSuburb(), 'Suburb 1');
        $this->assertEquals($this->instance->getCityId(), 66);
        $this->assertEquals($this->instance->getCity(), 'City 1');
        $this->assertEquals($this->instance->getZoneCode(), '99099000');
        $this->assertEquals($this->instance->setMask(true)->getZoneCode(), '99099-000');
        $this->assertEquals($this->instance->getZoneId(), 77);
        $this->assertEquals($this->instance->getZone(), 'Zone 1');
        $this->assertEquals($this->instance->getCountryId(), 88);
        $this->assertEquals($this->instance->getCountry(), 'Country 1');
    }
}

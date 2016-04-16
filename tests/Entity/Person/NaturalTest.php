<?php namespace Entity\Person;

use Entity\AbstractTest;

/**
* Teste da entidade Pessoa\Fisica
*
* @category Tests
*
*/
class NaturalTest extends AbstractTest
{
  private $instance;

  public function assertPreConditions()
  {
      $this->assertTrue(
              class_exists($class = '\Entity\Person\Natural'),
              'Class not found: '.$class
      );
      $this->instance = new \Entity\Person\Natural();
  }

  public function testInstantiationWithoutArgumentsShouldWork()
  {
    $this->assertInstanceOf('\Entity\Person\Natural', $this->instance);
  }

  /**
   * @expectedException UnexpectedValueException
   * @expectedExceptionMessage Você deve informar um documento principal.
   */
  public function testSetWithInvalidDataShouldThrownAnException()
  {
      $this->instance->setPrimaryDoc( null );
      $this->instance->setSecundaryDoc( null );
  }

  /**
   * @expectedException UnexpectedValueException
   * @expectedExceptionMessage Você deve informar um nome.
   */
  public function testSetWithInvalidDataNameShouldThrownAnException()
  {
      $this->instance->setName( null );
  }

  /**
   * @depends testInstantiationWithoutArgumentsShouldWork
   */
  public function testStringToNumber()
  {
    $string = '784.227.150-07';
    $comp = $this->instance->onlynumber($string);
    $this->assertEquals( $comp , 78422715007 );
  }

  /**
   * @depends testInstantiationWithoutArgumentsShouldWork
   */
  public function testReturnDoc1()
  {
    $return = $this->instance->setPrimaryDoc('784.227.150-07');
    $this->assertEquals( $this->instance->getPrimaryDoc() , 78422715007 );
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
    $this->assertEquals( $type , 1 );
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
   * @expectedException SecundaryDocInvalidException
   * @expectedExceptionMessage Documento principal inv&aacute;lido.
   */
  public function testSetWithInvalidSecundaryDocShouldThrownAnException()
  {
    $this->setExpectedException('\Entity\Person\Exceptions\SecundaryDocInvalidException');
    $this->instance->setSecundaryDoc( '1234567890' );
  }
}

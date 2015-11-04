<?php

use PhpCsv\Table;

class TableTest extends PHPUnit_Framework_TestCase
{

  /**
   * Tests the constructor, and by proxy, a lot of the other methods as well.
   */
  public function testConstructor()
  {
    $file = dirname(__FILE__) . '/data/simple.csv';
    $sut = new PhpCsv\Table($file);
  }

  /**
   * Tests the PhpCsv\Table::parseFile method.
   */
  public function testParseFile()
  {
    $sut = $this->getMockBuilder('PhpCsv\\Table')
      ->disableOriginalConstructor()
      ->getMock();

    $file = dirname(__FILE__) . '/data/simple.csv';
    $expected = file($file);

    $reflection = new ReflectionClass('PhpCsv\\Table');
    $reflection_method = $reflection->getMethod('parseFile');
    $reflection_method->setAccessible(true);
    $result = $reflection_method->invoke($sut, $file);

    $this->assertEquals($expected, $result);
  }

  /**
   * Tests the PhpCsv\Table::getPartsFromLine method.
   *
   * @param array $expected The expected result of the method.
   * @param string $line The raw line data.
   *
   * @dataProvider dataGetPartsFromLine
   */
  public function testGetPartsFromLine($expected, $line)
  {
    $sut = $this->getMockBuilder('PhpCsv\\Table')
      ->disableOriginalConstructor()
      ->getMock();

    $reflection = new ReflectionClass('PhpCsv\\Table');
    $reflection_method = $reflection->getMethod('getPartsFromLine');
    $reflection_method->setAccessible(true);
    $result = $reflection_method->invoke($sut, $line);

    $this->assertEquals($expected, $result);

  }

  /**
   * Data provider for testing PhpCsv\Table::getPartsFromLine
   *
   * @return array An array of data to use in testing.
   */
  public function dataGetPartsFromLine()
  {
    return array(
      // simple data, simple result
      'simple data, simple result' => array(
        'expected' => array(
          'test', 'thing', 'stuff'
        ),
        'line' => 'test,thing,stuff'
      ),

      // data with spaces, trimmed result
      'data with spaces, trimmed result' => array(
        'expected' => array(
          'test', 'thing', 'stuff'
        ),
        'line' => 'test, thing ,stuff'
      ),


    );
  }
}

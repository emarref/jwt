<?php

namespace Emarref\Jwt\HeaderParameter;

class AlgorithmTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'alg';
    private static $value = 'foobar';

    /**
     * @var Algorithm
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new Algorithm(self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->parameter->getName());
    }

    public function testGetValue()
    {
        $this->assertSame(self::$value, $this->parameter->getValue());
    }

    public function testSetValue()
    {
        $newValue = 'NewValue';

        $this->parameter->setValue($newValue);
        $this->assertSame($newValue, $this->parameter->getValue());
    }
}

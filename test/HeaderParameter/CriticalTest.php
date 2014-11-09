<?php

namespace Emarref\Jwt\HeaderParameter;

use Emarref\Jwt\Claim;

class CriticalTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'crit';
    private static $value = ['foobar'];

    /**
     * @var Critical
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new Critical(self::$value);
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
        $this->assertSame([$newValue], $this->parameter->getValue());
    }

    public function testAddClaim()
    {
        $parameter = new Custom('foo', 'bar');

        $this->parameter->addParameter($parameter);
        $expectedValue = [self::$value[0], 'foo'];

        $this->assertSame($expectedValue, $this->parameter->getValue());

        $this->parameter->addParameter($parameter);
        $this->assertSame($expectedValue, $this->parameter->getValue(), 'Add parameter duplicates claims');
    }
}

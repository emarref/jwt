<?php

namespace Emarref\Jwt\HeaderParameter;

class CustomTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'cus';
    private static $value = 'foobar';

    /**
     * @var Custom
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new Custom(self::$name, self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->parameter->getName());
    }

    public function testSetName()
    {
        $newValue = 'baz';

        $this->parameter->setName($newValue);

        $this->assertSame($newValue, $this->parameter->getName());
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

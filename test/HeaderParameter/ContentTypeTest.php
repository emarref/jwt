<?php

namespace Emarref\Jwt\HeaderParameter;

class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'cty';
    private static $value = 'foobar';

    /**
     * @var ContentType
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new ContentType(self::$value);
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

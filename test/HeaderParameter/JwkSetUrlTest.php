<?php

namespace Emarref\Jwt\HeaderParameter;

class JwkSetUrlTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'jku';
    private static $value = 'foobar';

    /**
     * @var JwkSetUrl
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new JwkSetUrl(self::$value);
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

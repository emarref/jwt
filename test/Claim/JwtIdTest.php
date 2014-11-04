<?php

namespace Emarref\Jwt\Claim;

class JwtIdTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'jti';
    private static $value = 'foobar';

    /**
     * @var JwtId
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new JwtId(self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->claim->getName());
    }

    public function testGetValue()
    {
        $this->assertSame(self::$value, $this->claim->getValue());
    }

    public function testSetValue()
    {
        $newValue = 'NewValue';

        $this->claim->setValue($newValue);
        $this->assertSame($newValue, $this->claim->getValue());
    }
}

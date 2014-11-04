<?php

namespace Emarref\Jwt\Claim;

class IssuerTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'iss';
    private static $value = 'foobar';

    /**
     * @var Issuer
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new Issuer(self::$value);
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

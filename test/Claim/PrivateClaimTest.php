<?php

namespace Emarref\Jwt\Claim;

class PrivateClaimTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'foo';
    private static $value = 'bar';

    /**
     * @var PrivateClaim
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new PrivateClaim(self::$name, self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->claim->getName());
    }

    public function testSetName()
    {
        $newName = 'baz';

        $this->claim->setName($newName);

        $this->assertSame($newName, $this->claim->getName());
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

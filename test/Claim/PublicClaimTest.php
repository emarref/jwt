<?php

namespace Emarref\Jwt\Claim;

class PublicClaimTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'foo://bar';
    private static $value = 'baz';

    /**
     * @var PublicClaim
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new PublicClaim(self::$name, self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->claim->getName());
    }

    public function testSetName()
    {
        $newName = 'foo://baz';

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

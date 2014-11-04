<?php

namespace Emarref\Jwt\Claim;

class AudienceTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'aud';
    private static $value = 'foobar';

    /**
     * @var Audience
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new Audience(self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->claim->getName());
    }

    public function testGetValue()
    {
        $this->assertSame(self::$value, $this->claim->getValue());
    }

    public function testStringValue()
    {
        $newValue = 'NewValue';

        $this->claim->setValue($newValue);
        $this->assertSame($newValue, $this->claim->getValue());
    }

    public function testArrayValue()
    {
        $this->claim->setValue([self::$value]);
        $this->assertSame([self::$value], $this->claim->getValue());
    }
}

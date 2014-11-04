<?php

namespace Emarref\Jwt\Claim;

class NotBeforeTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'nbf';
    private static $value = 1357002000;

    /**
     * @var NotBefore
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new NotBefore(self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->claim->getName());
    }

    public function testGetValue()
    {
        $this->assertSame(self::$value, $this->claim->getValue());
    }

    public function testTimestampValue()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->claim->setValue($now->getTimestamp());
        $this->assertSame($now->getTimestamp(), $this->claim->getValue());
    }

    public function testDateTimeValue()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->claim->setValue($now);
        $this->assertSame($now->getTimestamp(), $this->claim->getValue());
    }

    public function testTimezone()
    {
        $akl = new \DateTime('2014-01-01 13:00:00', new \DateTimeZone('Pacific/Auckland'));
        $utc = new \DateTime('2014-01-01 00:00:00', new \DateTimeZone('UTC'));

        $this->claim->setValue($akl);
        $this->assertSame($utc->getTimestamp(), $this->claim->getValue());
    }
}

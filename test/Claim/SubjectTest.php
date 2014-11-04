<?php

namespace Emarref\Jwt\Claim;

class SubjectTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'sub';
    private static $value = 'foobar';

    /**
     * @var Subject
     */
    private $claim;

    public function setUp()
    {
        $this->claim = new Subject(self::$value);
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

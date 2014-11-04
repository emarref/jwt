<?php

namespace Emarref\Jwt\Encoding;

class Base64Test extends \PHPUnit_Framework_TestCase
{
    private static $value = 'føøbarbaz';

    /**
     * @var Base64
     */
    private $defaultEncoding;

    /**
     * @var Base64
     */
    private $nonDefaultEncoding;

    public function setUp()
    {
        $this->defaultEncoding    = new Base64();
        $this->nonDefaultEncoding = new Base64(false, false);
    }

    public function testEncode()
    {
        $this->assertSame('ZsO4w7hiYXJiYXo', $this->defaultEncoding->encode(self::$value));
        $this->assertSame('ZsO4w7hiYXJiYXo=', $this->nonDefaultEncoding->encode(self::$value));
    }

    public function testDecode()
    {
        $this->assertSame(self::$value, $this->defaultEncoding->decode('ZsO4w7hiYXJiYXo'));
        $this->assertSame(self::$value, $this->nonDefaultEncoding->decode('ZsO4w7hiYXJiYXo='));
    }
}

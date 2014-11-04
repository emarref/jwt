<?php

namespace Emarref\Jwt\Algorithm;

class Hs512Test extends \PHPUnit_Framework_TestCase
{
    const ALGORITHM = 'sha512';

    private static $name   = 'HS512';
    private static $secret = 'secret';

    /**
     * @var Hs512
     */
    private $algorithm;

    public function setUp()
    {
        $this->algorithm = new Hs512(self::$secret);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testCompute()
    {
        $unencryptedValue = 'foobar';
        $encryptedValue   = hash_hmac(self::ALGORITHM, $unencryptedValue, self::$secret, true);
        $this->assertSame($encryptedValue, $this->algorithm->compute($unencryptedValue));
    }
}

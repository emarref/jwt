<?php

namespace Emarref\Jwt\Algorithm;

class Hs256Test extends \PHPUnit_Framework_TestCase
{
    const ALGORITHM = 'sha256';

    private static $name   = 'HS256';
    private static $secret = 'secret';

    /**
     * @var Hs256
     */
    private $algorithm;

    public function setUp()
    {
        $this->algorithm = new Hs256(self::$secret);
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

<?php

namespace Emarref\Jwt\Algorithm;

class Hs384Test extends \PHPUnit_Framework_TestCase
{
    const ALGORITHM = 'sha384';

    private static $name   = 'HS384';
    private static $secret = 'secret';

    /**
     * @var Hs384
     */
    private $algorithm;

    public function setUp()
    {
        $this->algorithm = new Hs384(self::$secret);
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

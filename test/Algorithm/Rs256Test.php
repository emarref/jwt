<?php

namespace Emarref\Jwt\Algorithm;

class Rs256Test extends \PHPUnit_Framework_TestCase
{
    private static $name = 'RS256';

    /**
     * @var string
     */
    private $key;

    /**
     * @var Rs256
     */
    private $algorithm;

    public function setUp()
    {
        $this->key = openssl_pkey_new();
        $this->algorithm = new Rs256($this->key);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testCompute()
    {
        $unencryptedValue = 'foobar';
        openssl_sign($unencryptedValue, $encryptedValue, $this->key, OPENSSL_ALGO_SHA256);
        $signature = $this->algorithm->compute($unencryptedValue);

        $this->assertSame($encryptedValue, $signature);
    }
}

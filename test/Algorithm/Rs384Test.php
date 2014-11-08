<?php

namespace Emarref\Jwt\Algorithm;

class Rs384Test extends \PHPUnit_Framework_TestCase
{
    private static $name          = 'RS384';
    private static $algorithmName = 'sha384';

    /**
     * @var string
     */
    private $key;

    /**
     * @var Rs384
     */
    private $algorithm;

    public function setUp()
    {
        $this->key = openssl_pkey_new();
        $this->algorithm = new Rs384();
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testGetAlgorithm()
    {
        $this->assertSame(self::$algorithmName, $this->algorithm->getAlgorithm());
    }

    public function testSign()
    {
        $unencryptedValue = 'foobar';
        openssl_sign($unencryptedValue, $encryptedValue, $this->key, OPENSSL_ALGO_SHA384);
        $signature = $this->algorithm->sign($unencryptedValue, $this->key);

        $this->assertSame($encryptedValue, $signature);
    }
}

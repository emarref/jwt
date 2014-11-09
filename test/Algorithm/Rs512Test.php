<?php

namespace Emarref\Jwt\Algorithm;

class Rs512Test extends \PHPUnit_Framework_TestCase
{
    private static $name          = 'RS512';
    private static $algorithmName = 'sha512';

    /**
     * @var string
     */
    private $key;

    /**
     * @var Rs512
     */
    private $algorithm;

    public function setUp()
    {
        $this->key = openssl_pkey_new();
        $this->algorithm = new Rs512();
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testGetAlgorithm()
    {
        $this->assertSame(self::$algorithmName, $this->algorithm->getAlgorithm());
    }

    public function testCompute()
    {
        $unencryptedValue = 'foobar';
        openssl_sign($unencryptedValue, $encryptedValue, $this->key, OPENSSL_ALGO_SHA512);
        $signature = $this->algorithm->sign($unencryptedValue, $this->key);

        $this->assertSame($encryptedValue, $signature);
    }
}

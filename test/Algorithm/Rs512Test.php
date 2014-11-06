<?php

namespace Emarref\Jwt\Algorithm;

require_once dirname(__FILE__).'/SslKeyPairTrait.php';

class Rs512Test extends \PHPUnit_Framework_TestCase
{
    use SslKeyPairTrait;

    private static $name = 'RS512';

    /**
     * @var string
     */
    private $keyPair;

    /**
     * @var Rs384
     */
    private $algorithm;

    public function setUp()
    {
        $this->keyPair = $this->generateKeyPair('sha512');
        $this->algorithm = new Rs512();
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testSign()
    {
        $unencryptedValue = 'foobar';
        openssl_sign($unencryptedValue, $encryptedValue, $this->keyPair['private'], OPENSSL_ALGO_SHA512);
        $signature = $this->algorithm->sign($unencryptedValue, $this->keyPair['private']);

        $this->assertSame($encryptedValue, $signature);
    }
}

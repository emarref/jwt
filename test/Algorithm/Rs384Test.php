<?php

namespace Emarref\Jwt\Algorithm;

require_once dirname(__FILE__).'/SslKeyPairTrait.php';

class Rs384Test extends \PHPUnit_Framework_TestCase
{
    use SslKeyPairTrait;

    private static $name = 'RS384';

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
        $this->keyPair = $this->generateKeyPair('sha384');
        $this->algorithm = new Rs384();
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testSign()
    {
        $unencryptedValue = 'foobar';
        openssl_sign($unencryptedValue, $encryptedValue, $this->keyPair['private'], OPENSSL_ALGO_SHA384);
        $signature = $this->algorithm->sign($unencryptedValue, $this->keyPair['private']);

        $this->assertSame($encryptedValue, $signature);
    }
}

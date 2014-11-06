<?php

namespace Emarref\Jwt\Algorithm;

require_once dirname(__FILE__).'/SslKeyPairTrait.php';

class Rs256Test extends \PHPUnit_Framework_TestCase
{
    use SslKeyPairTrait;

    private static $name = 'RS256';

    /**
     * @var string
     */
    private $keyPair;

    /**
     * @var Rs256
     */
    private $algorithm;

    public function setUp()
    {
        $this->keyPair = $this->generateKeyPair('sha256');
        $this->algorithm = new Rs256();
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->algorithm->getName());
    }

    public function testCompute()
    {
        $unencryptedValue = 'foobar';
        openssl_sign($unencryptedValue, $encryptedValue, $this->keyPair['private'], OPENSSL_ALGO_SHA256);
        $signature = $this->algorithm->sign($unencryptedValue, $this->keyPair['private']);

        $this->assertSame($encryptedValue, $signature);
    }
}

<?php

namespace Emarref\Jwt\Encryption;

class AsymmetricTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $algorithm;

    /**
     * @var Asymmetric
     */
    private $encryption;

    public function setUp()
    {
        $this->algorithm = $this->getMockBuilder('Emarref\Jwt\Algorithm\Rs256')->getMock();

        $this->encryption = new Asymmetric($this->algorithm);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetPrivateKeyUnavailable()
    {
        $this->encryption->getPrivateKey();
    }

    public function testPrivateKey()
    {
        $key = 'thisismykey';

        $this->encryption->setPrivateKey('thisismykey');

        $this->assertSame($key, $this->encryption->getPrivateKey());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetPublicKeyUnavailable()
    {
        $this->encryption->getPublicKey();
    }

    public function testPublicKey()
    {
        $key = 'thisismykey';

        $this->encryption->setPublicKey('thisismykey');

        $this->assertSame($key, $this->encryption->getPublicKey());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No private key available for encryption.
     */
    public function testEncryptNoPrivateKey()
    {
        $this->algorithm->expects($this->never())
            ->method('sign');

        $this->encryption->encrypt('myvalue');
    }

    public function testEncrypt()
    {
        $unencryptedValue = 'unencrypted_value';
        $encryptedValue   = 'encrypted_value';
        $privateKey       = 'private_key';

        $this->encryption->setPrivateKey($privateKey);

        $this->algorithm->expects($this->once())
            ->method('sign')
            ->with($unencryptedValue, $privateKey)
            ->will($this->returnValue($encryptedValue));

        $this->assertSame($encryptedValue, $this->encryption->encrypt($unencryptedValue));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No public key available for verification.
     */
    public function testVerifyNoPublicKey()
    {
        $this->algorithm->expects($this->never())
            ->method('verify');

        $this->encryption->verify('value', 'signature');
    }

    public function testVerify()
    {
        $value          = 'value';
        $signature      = 'signature';
        $publicKey      = 'public_key';
        $encryptedValue = 'encrypted_value';

        $this->encryption->setPublicKey($publicKey);

        $this->algorithm->expects($this->once())
            ->method('verify')
            ->with($value, $signature, $publicKey)
            ->will($this->returnValue($encryptedValue));

        $this->encryption->verify($value, $signature);
    }
}

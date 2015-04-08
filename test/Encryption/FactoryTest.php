<?php

namespace Emarref\Jwt\Encryption;

use Emarref\Jwt\Algorithm;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAsymmetricCreation()
    {
        $expectedEncryptionInstance = 'Emarref\Jwt\Encryption\Asymmetric';

        $algorithm = new Algorithm\Rs256();

        $this->assertInstanceOf($expectedEncryptionInstance, Factory::create($algorithm));
    }

    public function testSymmetricCreation()
    {
        $expectedEncryptionInstance = 'Emarref\Jwt\Encryption\Symmetric';

        $algorithm = new Algorithm\Hs256('secret');

        $this->assertInstanceOf($expectedEncryptionInstance, Factory::create($algorithm));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Algorithm of class "Emarref\Jwt\Encryption\UnknownAlgorithmStub" is neither symmetric or asymmetric.
     */
    public function testUnknownEncryption()
    {
        $algorithm = new UnknownAlgorithmStub();

        Factory::create($algorithm);
    }
}

<?php

namespace Emarref\Jwt\Encryption;

use Emarref\Jwt\Algorithm;

/**
 * @property Algorithm\AsymmetricInterface $algorithm
 */
class Asymmetric extends AbstractEncryption implements EncryptionInterface
{
    /**
     * @var string|resource
     */
    private $privateKey;

    /**
     * @var string|resource
     */
    private $publicKey;

    /**
     * @param Algorithm\AsymmetricInterface $algorithm
     */
    public function __construct(Algorithm\AsymmetricInterface $algorithm)
    {
        parent::__construct($algorithm);
    }

    /**
     * @return resource|string
     */
    public function getPrivateKey()
    {
        if (!$this->privateKey) {
            throw new \RuntimeException('No private key available for encryption.');
        }

        return $this->privateKey;
    }

    /**
     * @param resource|string $privateKey
     * @return $this
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * @return resource|string
     */
    public function getPublicKey()
    {
        if (!$this->publicKey) {
            throw new \RuntimeException('No public key available for verification.');
        }

        return $this->publicKey;
    }

    /**
     * @param resource|string $publicKey
     * @return $this
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value)
    {
        return $this->algorithm->sign($value, $this->getPrivateKey());
    }

    /**
     * @param string $value
     * @param string $signature
     * @return boolean
     */
    public function verify($value, $signature)
    {
        return $this->algorithm->verify($value, $signature, $this->getPublicKey());
    }
}

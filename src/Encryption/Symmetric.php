<?php

namespace Emarref\Jwt\Encryption;

use Emarref\Jwt\Algorithm;

/**
 * @property Algorithm\SymmetricInterface $algorithm
 */
class Symmetric extends AbstractEncryption implements EncryptionInterface
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @param Algorithm\SymmetricInterface $algorithm
     */
    public function __construct(Algorithm\SymmetricInterface $algorithm)
    {
        parent::__construct($algorithm);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value)
    {
        return $this->algorithm->compute($value);
    }

    /**
     * @param string $value
     * @param string $signature
     * @return boolean
     */
    public function verify($value, $signature)
    {
        return $this->algorithm->compute($value) === $signature;
    }
}

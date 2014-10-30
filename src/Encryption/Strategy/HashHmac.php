<?php

namespace Emarref\Jwt\Encryption\Strategy;

abstract class HashHmac implements EncryptionStrategyInterface
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;

        $this->ensureSupport();
    }

    private function ensureSupport()
    {
        $supportedAlgorithms = $this->getSupportedAlgorithms();

        if (!in_array($this->getAlgorithm(), $supportedAlgorithms)) {
            throw new \RuntimeException(sprintf(
                'Encryption algorithm "%s" is not supported on this system.',
                $this->getAlgorithm()
            ));
        }
    }

    protected function getSupportedAlgorithms()
    {
        return hash_algos();
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value)
    {
        return hash_hmac($this->getAlgorithm(), $value, $this->secret, true);
    }

    /**
     * @return string
     */
    abstract protected function getAlgorithm();
} 

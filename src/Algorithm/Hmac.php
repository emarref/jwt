<?php

namespace Emarref\Jwt\Algorithm;

abstract class Hmac implements SymmetricInterface
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

    /**
     * @throws \RuntimeException
     */
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

    /**
     * @return array
     */
    protected function getSupportedAlgorithms()
    {
        return hash_algos();
    }

    /**
     * @param string $value
     * @return string
     */
    public function compute($value)
    {
        return hash_hmac($this->getAlgorithm(), $value, $this->secret, true);
    }

    /**
     * @return string
     */
    abstract protected function getAlgorithm();
}

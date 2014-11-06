<?php

namespace Emarref\Jwt\Algorithm;

abstract class Hmac implements AlgorithmInterface
{
    public function __construct()
    {
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
     * @param $message
     * @param $secret
     * @return string
     */
    public function sign($message, $secret) {
        return hash_hmac($this->getAlgorithm(), $message, $secret, true);
    }

    /**
     * @param $message
     * @param $signature
     * @param $secret
     * @return boolean
     */
    public function check($message, $signature, $secret) {
        return hash_hmac($this->getAlgorithm(), $message, $secret, true) == $signature;
    }

    /**
     * @return string
     */
    abstract protected function getAlgorithm();
} 

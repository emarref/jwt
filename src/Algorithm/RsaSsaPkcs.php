<?php

namespace Emarref\Jwt\Algorithm;

abstract class RsaSsaPkcs implements AlgorithmInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;

        $this->ensureSupport();
    }

    /**
     * @throws \RuntimeException
     */
    public function ensureSupport()
    {
        if (!function_exists('openssl_sign')) {
            throw new \RuntimeException('The "openssl_sign()" function is required to use RSA encryption.');
        }
    }

    /**
     * @throws \RuntimeException
     */
    private function throwEncryptionException()
    {
        $messages = [];

        while ($msg = openssl_error_string()) {
            $messages[] = $msg;
        }

        throw new \RuntimeException('Failed to encrypt value. ' . implode("\n", $messages));
    }

    /**
     * @param string $value
     * @return string
     */
    public function compute($value)
    {
        $result = openssl_sign($value, $signature, $this->key, $this->getAlgorithm());

        if (false === $result) {
            $this->throwEncryptionException();
        }

        return $signature;
    }

    /**
     * @return integer
     */
    abstract protected function getAlgorithm();
} 

<?php

namespace Emarref\Jwt\Encryption;

abstract class RsaSignature implements StrategyInterface
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

    public function ensureSupport()
    {
        if (!function_exists('openssl_sign')) {
            throw new \RuntimeException('The "openssl_sign()" function is required to use RSA encryption.');
        }
    }

    /**
     * @throws \RuntimeException
     */
    private function throwEncryptionFailure()
    {
        $messages = [];

        while ($msg = openssl_error_string()) {
            $messages[] = $msg;
        }

        throw new \RuntimeException('Failed to encrypt value. ' . implode("\n", $messages));
    }

    public function encrypt($value)
    {
        $result = openssl_sign($value, $signature, $this->key, $this->getAlgorithm());

        if (false === $result) {
            $this->throwEncryptionFailure();
        }

        return $signature;
    }

    /**
     * @return integer
     */
    abstract protected function getAlgorithm();
} 

<?php

namespace Emarref\Jwt\Algorithm;

abstract class RsaSsaPkcs implements AlgorithmInterface
{
    public function __construct()
    {
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
        $messages = $this->getSslErrors();
        throw new \RuntimeException('Failed to encrypt value. ' . implode("\n", $messages));
    }

    /**
     * @throws \RuntimeException
     */
    private function throwDecryptionException()
    {
        $messages = $this->getSslErrors();
        throw new \RuntimeException('Failed to decrypt value. ' . implode("\n", $messages));
    }

    /**
     * @return array
     */
    private function getSslErrors()
    {
        $messages = [];
        while ($msg = openssl_error_string()) {
            $messages[] = $msg;
        }

        return $messages;
    }

    /**
     * @param $message
     * @param $private_key
     * @return string
     */
    public function sign($message, $private_key)
    {
        $result = openssl_sign($message, $signature, $private_key, $this->getAlgorithm());

        if (false === $result) {
            $this->throwEncryptionException();
        }

        return $signature;
    }

    /**
     * @param string $message
     * @param string $signature
     * @param string $public_key
     * @return bool
     */
    public function check($message, $signature, $public_key) {
        $result = openssl_verify($message, $signature, $public_key, $this->getAlgorithm());

        if (-1 == $result) {
            $this->throwDecryptionException();
        }

        return (boolean)$result;
    }

    /**
     * @return integer
     */
    abstract protected function getAlgorithm();
} 

<?php

namespace Emarref\Jwt\Algorithm;

abstract class RsaSsaPkcs implements AsymmetricInterface
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
            throw new \RuntimeException('Openssl is required to use RSA encryption.');
        }

        $supportedAlgorithms = openssl_get_md_methods(true);

        if (!in_array($this->getAlgorithm(), $supportedAlgorithms)) {
            throw new \RuntimeException('Algorithm "%s" is not supported on this system.', $this->getAlgorithm());
        }
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
     * @param string          $value
     * @param string|resource $privateKey
     * @return string
     */
    public function sign($value, $privateKey)
    {
        $result = openssl_sign($value, $signature, $privateKey, $this->getAlgorithm());

        if (false === $result) {
            throw new \RuntimeException('Failed to encrypt value. ' . implode("\n", $this->getSslErrors()));
        }

        return $signature;
    }

    /**
     * @param string          $value
     * @param string          $signature
     * @param string|resource $publicKey
     * @return boolean
     */
    public function verify($value, $signature, $publicKey)
    {
        $result = openssl_verify($value, $signature, $publicKey, $this->getAlgorithm());

        if ($result === -1) {
            throw new \RuntimeException('Failed to verify signature. ' . implode("\n", $this->getSslErrors()));
        }

        return (boolean)$result;
    }

    /**
     * @return integer
     */
    abstract protected function getAlgorithm();
}

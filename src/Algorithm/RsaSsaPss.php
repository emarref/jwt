<?php

namespace Emarref\Jwt\Algorithm;

abstract class RsaSsaPss implements AsymmetricInterface
{
    public function __construct()
    {
        throw new \RuntimeException('Not implemented');
    }

    /**
     * @param string          $value
     * @param string|resource $privateKey
     * @return string
     */
    public function sign($value, $privateKey)
    {
        // Noop
    }

    /**
     * @param string          $value
     * @param string          $signature
     * @param string|resource $publicKey
     * @return boolean
     */
    public function verify($value, $signature, $publicKey)
    {
        // Noop
    }
}

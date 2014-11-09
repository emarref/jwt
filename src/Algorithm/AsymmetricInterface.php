<?php

namespace Emarref\Jwt\Algorithm;

interface AsymmetricInterface extends AlgorithmInterface
{
    /**
     * @param string          $value
     * @param string|resource $privateKey
     * @return string
     */
    public function sign($value, $privateKey);

    /**
     * @param string          $value
     * @param string          $signature
     * @param string|resource $publicKey
     * @return boolean
     */
    public function verify($value, $signature, $publicKey);
}

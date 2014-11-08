<?php

namespace Emarref\Jwt\Encryption;

interface EncryptionInterface
{
    /**
     * @return string
     */
    public function getAlgorithmName();

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value);

    /**
     * @param string $value
     * @param string $signature
     * @return boolean
     */
    public function verify($value, $signature);
}

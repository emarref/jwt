<?php

namespace Emarref\Jwt\Encryption\Strategy;

interface EncryptionStrategyInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value);
} 

<?php

namespace Emarref\Jwt\Encryption\Strategy;

class None implements EncryptionStrategyInterface
{
    const NAME = 'NONE';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value)
    {
        return '';
    }
} 

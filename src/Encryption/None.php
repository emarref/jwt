<?php

namespace Emarref\Jwt\Encryption;

class None implements StrategyInterface
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

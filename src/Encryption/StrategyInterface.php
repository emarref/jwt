<?php

namespace Emarref\Jwt\Encryption;

interface StrategyInterface
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

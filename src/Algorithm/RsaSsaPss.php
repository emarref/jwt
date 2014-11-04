<?php

namespace Emarref\Jwt\Algorithm;

abstract class RsaSsaPss implements AlgorithmInterface
{
    public function __construct()
    {
        throw new \RuntimeException('Not implemented');
    }

    /**
     * @param string $value
     * @return string
     */
    public function compute($value)
    {
        // Noop
    }
} 

<?php

namespace Emarref\Jwt\Algorithm;

interface AlgorithmInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $value
     * @return string
     */
    public function compute($value);
} 

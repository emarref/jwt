<?php

namespace Emarref\Jwt\Algorithm;

abstract class RsaSsaPss implements AlgorithmInterface
{
    public function __construct()
    {
        throw new \RuntimeException('Not implemented');
    }

    /**
     * @param $message
     * @param $private_key
     * @return string
     */
    public function sign($message, $private_key)
    {
        //noop
    }

    /**
     * @param string $message
     * @param string $signature
     * @param string $public_key
     * @return bool
     */
    public function check($message, $signature, $public_key) {
        //noop
    }
} 

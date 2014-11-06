<?php

namespace Emarref\Jwt\Algorithm;

abstract class EcdSa implements AlgorithmInterface
{
    public function __construct()
    {
        throw new \RuntimeException('Not implemented');
    }

    /**
     * @param $message
     * @param $key
     * @return string
     */
    public function sign($message, $key) {
        // noop
    }

    /**
     * @param $message
     * @param $signature
     * @param $key
     * @return boolean
     */
    public function check($message, $signature, $key) {
        // noop
    }


} 

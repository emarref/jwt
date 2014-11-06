<?php

namespace Emarref\Jwt\Algorithm;

class None implements AlgorithmInterface
{
    const NAME = 'none';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param $message
     * @param $secret
     * @return string
     */
    public function sign($message, $secret) {
        return $message;
    }

    /**
     * @param $message
     * @param $signature
     * @param $secret
     * @return boolean
     */
    public function check($message, $signature, $secret) {
        return $message == $signature;
    }
} 

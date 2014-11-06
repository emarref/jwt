<?php

namespace Emarref\Jwt\Algorithm;

interface AlgorithmInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param $message
     * @param $key
     * @return string
     */
    public function sign($message, $key);

    /**
     * @param string $message
     * @param string $signature
     * @param string $key
     * @return boolean
     */
    public function check($message, $signature, $key);
}

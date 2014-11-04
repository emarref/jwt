<?php

namespace Emarref\Jwt\Algorithm;

class Rs256 extends RsaSsaPkcs
{
    const NAME = 'RS256';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @return int
     */
    public function getAlgorithm()
    {
        return OPENSSL_ALGO_SHA256;
    }
}

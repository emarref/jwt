<?php

namespace Emarref\Jwt\Encryption\Strategy;

class Rs384 extends RsaSignature
{
    const NAME = 'RS384';

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
        return OPENSSL_ALGO_SHA384;
    }
}

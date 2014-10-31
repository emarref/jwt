<?php

namespace Emarref\Jwt\Encryption;

class Rs256 extends RsaSignature
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

<?php

namespace Emarref\Jwt\Encryption;

class Rs512 extends RsaSignature
{
    const NAME = 'RS512';

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
        return OPENSSL_ALGO_SHA512;
    }
}

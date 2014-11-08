<?php

namespace Emarref\Jwt\Algorithm;

class Rs512 extends RsaSsaPkcs
{
    const NAME      = 'RS512';
    const ALGORITHM = 'sha512';

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
        return self::ALGORITHM;
    }
}

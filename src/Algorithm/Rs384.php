<?php

namespace Emarref\Jwt\Algorithm;

class Rs384 extends RsaSsaPkcs
{
    const NAME      = 'RS384';
    const ALGORITHM = 'sha384';

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

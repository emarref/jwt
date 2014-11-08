<?php

namespace Emarref\Jwt\Algorithm;

class Rs256 extends RsaSsaPkcs
{
    const NAME      = 'RS256';
    const ALGORITHM = 'sha256';

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

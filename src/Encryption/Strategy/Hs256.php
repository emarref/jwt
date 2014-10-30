<?php

namespace Emarref\Jwt\Encryption\Strategy;

class Hs256 extends HashHmac
{
    const NAME      = 'HS256';
    const ALGORITHM = 'sha256';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    protected function getAlgorithm()
    {
        return self::ALGORITHM;
    }
} 

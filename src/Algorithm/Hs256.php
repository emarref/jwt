<?php

namespace Emarref\Jwt\Algorithm;

class Hs256 extends Hmac
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

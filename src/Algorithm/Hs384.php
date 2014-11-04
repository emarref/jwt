<?php

namespace Emarref\Jwt\Algorithm;

class Hs384 extends Hmac
{
    const NAME      = 'HS384';
    const ALGORITHM = 'sha384';

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

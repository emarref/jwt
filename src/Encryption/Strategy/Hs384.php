<?php

namespace Emarref\Jwt\Encryption\Strategy;

class Hs384 extends HashHmac
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

<?php

namespace Emarref\Jwt\Algorithm;

class Hs512 extends Hmac
{
    const NAME      = 'HS512';
    const ALGORITHM = 'sha512';

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

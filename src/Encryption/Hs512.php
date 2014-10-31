<?php

namespace Emarref\Jwt\Encryption;

class Hs512 extends HashHmac
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

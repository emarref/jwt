<?php

namespace Emarref\Jwt\Algorithm;

class Ps384 extends RsaSsaPss
{
    const NAME = 'PS384';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}

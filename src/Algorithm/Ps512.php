<?php

namespace Emarref\Jwt\Algorithm;

class Ps512 extends RsaSsaPss
{
    const NAME = 'PS512';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}

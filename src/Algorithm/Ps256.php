<?php

namespace Emarref\Jwt\Algorithm;

class Ps256 extends RsaSsaPss
{
    const NAME = 'PS256';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}

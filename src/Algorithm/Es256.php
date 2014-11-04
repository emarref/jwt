<?php

namespace Emarref\Jwt\Algorithm;

class Es256 extends EcdSa
{
    const NAME = 'ES256';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 

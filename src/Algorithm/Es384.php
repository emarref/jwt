<?php

namespace Emarref\Jwt\Algorithm;

class Es384 extends EcdSa
{
    const NAME = 'ES384';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 

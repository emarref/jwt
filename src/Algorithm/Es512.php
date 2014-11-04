<?php

namespace Emarref\Jwt\Algorithm;

class Es512 extends EcdSa
{
    const NAME = 'ES512';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 

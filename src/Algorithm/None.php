<?php

namespace Emarref\Jwt\Algorithm;

class None implements SymmetricInterface
{
    const NAME = 'none';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param string $value
     * @return string
     */
    public function compute($value)
    {
        return '';
    }
}

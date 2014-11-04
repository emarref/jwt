<?php

namespace Emarref\Jwt\Claim;

class Subject extends AbstractClaim
{
    const NAME = 'sub';

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
} 

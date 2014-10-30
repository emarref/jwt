<?php

namespace Emarref\Jwt\Token\Payload\Claim;

class SubjectClaim extends AbstractClaim
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

<?php

namespace Emarref\Jwt\Token\Payload\Claim;

use Emarref\Jwt\Registry as BaseRegistry;

/**
 * @method ClaimInterface resolve(string $name)
 */
class Registry extends BaseRegistry
{
    const REQUIRED_INTERFACE  = 'Emarref\Jwt\Token\Payload\Claim\ClaimInterface';
    const DEFAULT_CLAIM_CLASS = 'Emarref\Jwt\Token\Payload\Claim\PrivateClaim';

    /**
     * @return string
     */
    public function getRequiredInterface()
    {
        return self::REQUIRED_INTERFACE;
    }

    /**
     * @return string
     */
    public function getDefaultClass()
    {
        return self::DEFAULT_CLAIM_CLASS;
    }
} 

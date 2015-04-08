<?php

namespace Emarref\Jwt\Claim;

use Emarref\Jwt\FactoryTrait;

/**
 * @method ClaimInterface get(string $name)
 */
class Factory
{
    use FactoryTrait;

    /**
     * @var string
     */
    private static $privateClaimClass = 'Emarref\Jwt\Claim\PrivateClaim';

    /**
     * @var array
     */
    private static $classMap = [
        Audience::NAME   => 'Emarref\Jwt\Claim\Audience',
        Expiration::NAME => 'Emarref\Jwt\Claim\Expiration',
        IssuedAt::NAME   => 'Emarref\Jwt\Claim\IssuedAt',
        Issuer::NAME     => 'Emarref\Jwt\Claim\Issuer',
        JwtId::NAME      => 'Emarref\Jwt\Claim\JwtId',
        NotBefore::NAME  => 'Emarref\Jwt\Claim\NotBefore',
        Subject::NAME    => 'Emarref\Jwt\Claim\Subject',
    ];

    /**
     * @return array
     */
    protected function getClassMap()
    {
        return self::$classMap;
    }

    /**
     * @return string
     */
    protected function getDefaultClass()
    {
        return self::$privateClaimClass;
    }
}

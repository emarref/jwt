<?php

namespace Emarref\Jwt\Claim;

class Factory
{
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
     * @param string $name
     * @return ClaimInterface
     */
    public function get($name)
    {
        if (isset(self::$classMap[$name])) {
            $class     = self::$classMap[$name];
            $parameter = new $class();
        } else {
            $class     = self::$privateClaimClass;
            $parameter = new $class($name);
        }

        return $parameter;
    }
}

<?php

namespace Emarref\Jwt\HeaderParameter;

use Emarref\Jwt\FactoryTrait;

/**
 * @method ParameterInterface get(string $name)
 */
class Factory
{
    use FactoryTrait;

    /**
     * @var string
     */
    private static $customParameterClass = 'Emarref\Jwt\HeaderParameter\Custom';

    /**
     * @var array
     */
    private static $classMap = [
        Algorithm::NAME                       => 'Emarref\Jwt\HeaderParameter\Algorithm',
        ContentType::NAME                     => 'Emarref\Jwt\HeaderParameter\ContentType',
        Critical::NAME                        => 'Emarref\Jwt\HeaderParameter\Critical',
        JsonWebKey::NAME                      => 'Emarref\Jwt\HeaderParameter\JsonWebKey',
        JwkSetUrl::NAME                       => 'Emarref\Jwt\HeaderParameter\JwkSetUrl',
        KeyId::NAME                           => 'Emarref\Jwt\HeaderParameter\KeyId',
        Type::NAME                            => 'Emarref\Jwt\HeaderParameter\Type',
        X509CertificateChain::NAME            => 'Emarref\Jwt\HeaderParameter\X509CertificateChain',
        X509CertificateSha1Thumbprint::NAME   => 'Emarref\Jwt\HeaderParameter\X509CertificateSha1Thumbprint',
        X509CertificateSha256Thumbprint::NAME => 'Emarref\Jwt\HeaderParameter\X509CertificateSha256Thumbprint',
        X509Url::NAME                         => 'Emarref\Jwt\HeaderParameter\X509Url',
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
        return self::$customParameterClass;
    }
}

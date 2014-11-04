<?php

namespace Emarref\Jwt\HeaderParameter;

class Factory
{
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
     * @param string $name
     * @return ParameterInterface
     */
    public function get($name)
    {
        if (isset(self::$classMap[$name])) {
            $class = self::$classMap[$name];
            $parameter = new $class();
        } else {
            $class = self::$customParameterClass;
            $parameter = new $class($name);
        }

        return $parameter;
    }
}

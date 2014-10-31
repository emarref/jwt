<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Encryption;
use Emarref\Jwt\Token\Payload\Claim;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    const HMAC_SECRET = 'secret';

    /**
     * @var Jwt
     */
    private $jwt;

    public function setUp()
    {
        $key = openssl_pkey_new();

        $this->jwt = new Jwt();
        $this->jwt->registerEncryptionStrategy(new Encryption\Hs256(self::HMAC_SECRET));
        $this->jwt->registerEncryptionStrategy(new Encryption\Hs384(self::HMAC_SECRET));
        $this->jwt->registerEncryptionStrategy(new Encryption\Hs512(self::HMAC_SECRET));
        $this->jwt->registerEncryptionStrategy(new Encryption\Rs256($key));
        $this->jwt->registerEncryptionStrategy(new Encryption\Rs384($key));
        $this->jwt->registerEncryptionStrategy(new Encryption\Rs512($key));
    }

    public function testEncode()
    {
        $token = $this->jwt->createToken();
        $token->addClaim(new Claim\IssuerClaim('issuer'));
        $this->assertSame('eyJhbGciOiJOT05FIn0.eyJpc3MiOiJpc3N1ZXIifQ.', $this->jwt->encode($token));
    }

    public function testDecode()
    {
        $token = $this->jwt->decode('eyJhbGciOiJIUzI1NiJ9.W10.tYdGHAF7YBfiFrnqtcsM-PIsGDradtWY3a2xM-xQiN8');
        $this->assertSame('{}', $token->getPayload()->jsonSerialize());
        $this->assertSame('{"alg":"HS256"}', $token->getHeader()->jsonSerialize());
    }
} 

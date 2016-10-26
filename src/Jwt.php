<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Algorithm;
use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Encryption;
use Emarref\Jwt\Exception;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Serialization;
use Emarref\Jwt\Signature;
use Emarref\Jwt\Verification;

class Jwt
{
    /**
     * @var Encoding\EncoderInterface
     */
    private $encoder;

    /**
     * @var Serialization\SerializerInterface
     */
    private $serialization;

    public function __construct()
    {
        $this->encoder = new Encoding\Base64();

        $this->serialization = new Serialization\Compact(
            $this->encoder,
            new HeaderParameter\Factory(),
            new Claim\Factory()
        );
    }

    /**
     * @param string $jwt
     * @param array $tokenOptions
     * @return Token
     */
    public function deserialize($jwt, array $tokenOptions = [])
    {
        return $this->serialization->deserialize($jwt, $tokenOptions);
    }

    /**
     * @param Token                          $token
     * @param Encryption\EncryptionInterface $encryption
     * @return string
     */
    public function serialize(Token $token, Encryption\EncryptionInterface $encryption)
    {
        $this->sign($token, $encryption);

        return $this->serialization->serialize($token);
    }

    /**
     * @param Token                          $token
     * @param Encryption\EncryptionInterface $encryption
     */
    public function sign(Token $token, Encryption\EncryptionInterface $encryption)
    {
        $signer = new Signature\Jws($encryption, $this->encoder);

        $signer->sign($token);
    }

    /**
     * @param Verification\Context $context
     * @return Verification\VerifierInterface[]
     */
    protected function getVerifiers(Verification\Context $context)
    {
        return [
            new Verification\EncryptionVerifier($context->getEncryption(), $this->encoder),
            new Verification\AudienceVerifier($context->getAudience()),
            new Verification\ExpirationVerifier(),
            new Verification\IssuerVerifier($context->getIssuer()),
            new Verification\SubjectVerifier($context->getSubject()),
            new Verification\NotBeforeVerifier(),
        ];
    }

    /**
     * @param Token                $token
     * @param Verification\Context $context
     * @return bool
     */
    public function verify(Token $token, Verification\Context $context)
    {
        foreach ($this->getVerifiers($context) as $verifier) {
            $verifier->verify($token);
        }

        return true;
    }
}

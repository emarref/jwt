<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Algorithm;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\Encryption;
use Emarref\Jwt\Exception\VerificationException;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Signature;
use Emarref\Jwt\Token;

class EncryptionVerifier implements VerifierInterface
{
    /**
     * @var Encryption\EncryptionInterface
     */
    private $encryption;

    /**
     * @var Encoding\EncoderInterface
     */
    private $encoder;

    /**
     * @param Encryption\EncryptionInterface $encryption
     * @param Encoding\EncoderInterface    $encoder
     */
    public function __construct(Encryption\EncryptionInterface $encryption, Encoding\EncoderInterface $encoder)
    {
        $this->encryption = $encryption;
        $this->encoder    = $encoder;
    }

    /**
     * @param Token $token
     * @throws VerificationException
     */
    public function verify(Token $token)
    {
        /** @var HeaderParameter\Algorithm $algorithmParameter */
        $algorithmParameter = $token->getHeader()->findParameterByName(HeaderParameter\Algorithm::NAME);

        if (null === $algorithmParameter) {
            throw new \RuntimeException('Algorithm parameter not found in token header.');
        }

        if ($algorithmParameter->getValue() !== $this->encryption->getAlgorithmName()) {
            throw new \RuntimeException(sprintf(
                'Cannot use "%s" algorithm to decrypt token encrypted with algorithm "%s".',
                $this->encryption->getAlgorithmName(),
                $algorithmParameter->getValue()
            ));
        }

        $signer = new Signature\Jws($this->encryption, $this->encoder);

        if (!$this->encryption->verify($signer->getUnsignedValue($token), $token->getSignature())) {
            throw new VerificationException('Signature is invalid.');
        }
    }
}

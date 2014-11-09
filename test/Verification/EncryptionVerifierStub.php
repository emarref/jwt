<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Encoding;
use Emarref\Jwt\Encryption;
use Emarref\Jwt\Signature\SignerInterface;

class EncryptionVerifierStub extends EncryptionVerifier
{
    public function __construct(
        Encryption\EncryptionInterface $encryption,
        Encoding\EncoderInterface $encoder,
        SignerInterface $signer
    ) {
        parent::__construct($encryption, $encoder);
        $this->signer = $signer;
    }
}

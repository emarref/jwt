<?php

namespace Emarref\Jwt\Exception;

class InvalidSignatureException extends VerificationException
{
    protected $message = 'Signature is invalid.';
}

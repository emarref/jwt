<?php

namespace Emarref\Jwt\Exception;

class InvalidIssuerException extends VerificationException
{
    protected $message = 'Issuer is invalid.';
}

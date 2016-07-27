<?php

namespace Emarref\Jwt\Exception;

class InvalidIssuerException extends VerificationException
{
    public function __construct($message = 'Issuer is invalid.', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

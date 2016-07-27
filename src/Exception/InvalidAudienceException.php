<?php

namespace Emarref\Jwt\Exception;

class InvalidAudienceException extends VerificationException
{
    public function __construct($message = 'Audience is invalid.', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

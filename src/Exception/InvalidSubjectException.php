<?php

namespace Emarref\Jwt\Exception;

class InvalidSubjectException extends VerificationException
{
    public function __construct($message = 'Subject is invalid.', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

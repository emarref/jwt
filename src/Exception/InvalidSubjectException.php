<?php

namespace Emarref\Jwt\Exception;

class InvalidSubjectException extends VerificationException
{
    protected $message = 'Subject is invalid.';
}

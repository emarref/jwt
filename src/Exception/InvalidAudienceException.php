<?php

namespace Emarref\Jwt\Exception;

class InvalidAudienceException extends VerificationException
{
    protected $message = 'Audience is invalid.';
}

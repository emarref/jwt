<?php

namespace Emarref\Jwt\Exception;

class VerificationException extends \Exception
{
    const CODE_INVALID_SIGNATURE = 1;
    const CODE_INVALID_AUDIENCE = 2;
    const CODE_EXPIRED = 3;
    const CODE_INVALID_ISSUER = 4;
    const CODE_INVALID_SUBJECT = 5;
    const CODE_INVALID_NOT_BEFORE = 6;
}

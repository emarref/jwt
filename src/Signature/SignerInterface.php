<?php

namespace Emarref\Jwt\Signature;

use Emarref\Jwt\Token;

interface SignerInterface
{
    /**
     * @param Token $token
     */
    public function sign(Token $token);
}

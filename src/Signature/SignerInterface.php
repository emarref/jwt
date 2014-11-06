<?php

namespace Emarref\Jwt\Signature;

use Emarref\Jwt\Token;

interface SignerInterface
{
    /**
     * @param Token $token
     * @param string $signingKey
     */
    public function sign(Token $token, $signingKey);
}

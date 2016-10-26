<?php

namespace Emarref\Jwt\Serialization;

use Emarref\Jwt\Token;

interface SerializerInterface
{
    /**
     * @param string $jwt
     * @param array $tokenOptions
     * @return Token
     */
    public function deserialize($jwt, array $tokenOptions = []);

    /**
     * @param Token $token
     * @return string
     */
    public function serialize(Token $token);
}

<?php

namespace Emarref\Jwt\Serialization;

use Emarref\Jwt\Token;

interface SerializerInterface
{
    /**
     * @param string $jwt
     * @return Token
     */
    public function deserialize($jwt);

    /**
     * @param Token $token
     * @return string
     */
    public function serialize(Token $token);
}

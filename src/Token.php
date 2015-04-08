<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Claim;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token\Header;
use Emarref\Jwt\Token\Payload;

class Token
{
    /**
     * @var Header
     */
    private $header;

    /**
     * @var Payload
     */
    private $payload;

    /**
     * @var string
     */
    private $signature;

    public function __construct()
    {
        $this->header  = new Header();
        $this->payload = new Payload();
    }

    /**
     * @param HeaderParameter\ParameterInterface $parameter
     * @param bool                               $critical
     */
    public function addHeader(HeaderParameter\ParameterInterface $parameter, $critical = false)
    {
        $this->header->setParameter($parameter, $critical);
    }

    /**
     * @param Claim\ClaimInterface $claim
     */
    public function addClaim(Claim\ClaimInterface $claim)
    {
        $this->payload->setClaim($claim);
    }

    /**
     * @return Token\Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return Token\Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }
}

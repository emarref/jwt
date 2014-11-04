<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Claim;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token\Header;

class Token
{
    /**
     * @var Token\Header
     */
    private $header;

    /**
     * @var Token\Payload
     */
    private $payload;

    /**
     * @var string
     */
    private $signature;

    public function __construct()
    {
        $this->header  = new Token\Header();
        $this->payload = new Token\Payload();
    }

    /**
     * @param HeaderParameter\ParameterInterface $parameter
     */
    public function addHeader(HeaderParameter\ParameterInterface $parameter)
    {
        $this->header->setParameter($parameter);
    }

    /**
     * @param Claim\ClaimInterface $claim
     * @param bool                 $critical
     */
    public function addClaim(Claim\ClaimInterface $claim, $critical = false)
    {
        $this->payload->setClaim($claim);

        if ($critical) {
            $this->header->addCriticalClaim($claim);
        }
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

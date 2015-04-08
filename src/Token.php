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

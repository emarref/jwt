<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\Token\Header;
use Emarref\Jwt\Token\Payload;

class Token
{
    /**
     * @var Header\Header
     */
    private $header;

    /**
     * @var Payload\Payload
     */
    private $payload;

    public function __construct()
    {
        $this->header  = new Header\Header();
        $this->payload = new Payload\Payload();
    }

    public function addHeader(Header\Parameter\ParameterInterface $parameter)
    {
        $this->header->setParameter($parameter);
    }

    /**
     * @param Payload\Claim\ClaimInterface $claim
     * @param bool                         $critical
     */
    public function addClaim(Payload\Claim\ClaimInterface $claim, $critical = false)
    {
        $this->payload->setClaim($claim);

        if ($critical) {
            $this->header->addCriticalClaim($claim);
        }
    }

    /**
     * @return Header\Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return Payload\Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }
}

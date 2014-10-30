<?php

namespace Emarref\Jwt\Token\Payload;

use Emarref\Jwt\Token\Payload\Claim\ClaimInterface;
use Emarref\Jwt\Token\PropertyList;

class Payload implements \JsonSerializable
{
    /**
     * @var PropertyList
     */
    private $propertyList;

    public function __construct()
    {
        $this->propertyList = new PropertyList();
    }

    /**
     * @param ClaimInterface $claim
     */
    public function setClaim(ClaimInterface $claim)
    {
        $this->propertyList->setProperty($claim);
    }

    /**
     * @param string $name
     * @return Claim\ClaimInterface|null
     */
    public function findClaimByName($name)
    {
        foreach ($this->propertyList as $claim) {
            /** @var Claim\ClaimInterface $claim */
            if ($claim->getName() === $name) {
                return $claim;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->propertyList->jsonSerialize();
    }
}

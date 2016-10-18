<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\Claim;

class Payload extends AbstractTokenBody
{
    /**
     * @param Claim\ClaimInterface $claim
     */
    public function setClaim(Claim\ClaimInterface $claim)
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
     * @return PropertyList
     */
    public function getClaims()
    {
        return $this->propertyList;
    }
}

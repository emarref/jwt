<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Claim;

class Header implements \JsonSerializable
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
     * @param HeaderParameter\ParameterInterface $parameter
     */
    public function setParameter(HeaderParameter\ParameterInterface $parameter)
    {
        $this->propertyList->setProperty($parameter);
    }

    /**
     * @param Claim\ClaimInterface $claim
     */
    public function addCriticalClaim(Claim\ClaimInterface $claim)
    {
        /** @var HeaderParameter\Critical $criticalParameter */
        $criticalParameter = $this->findParameterByName(HeaderParameter\Critical::NAME);

        if (!$criticalParameter) {
            $criticalParameter = new HeaderParameter\Critical();
        }

        $criticalParameter->addClaim($claim);
        $this->setParameter($criticalParameter);
    }

    /**
     * @param string $name
     * @return HeaderParameter\ParameterInterface|null
     */
    public function findParameterByName($name)
    {
        foreach ($this->propertyList as $parameter) {
            /** @var HeaderParameter\ParameterInterface $parameter */
            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }

        return null;
    }

    /**
     * @param string $name
     */
    public function removeParameterByName($name)
    {
        $this->propertyList->removeProperty($name);
    }

    /**
     * @return PropertyList
     */
    public function getParameters()
    {
        return clone $this->propertyList;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->propertyList->jsonSerialize();
    }
}

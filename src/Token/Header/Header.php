<?php

namespace Emarref\Jwt\Token\Header;

use Emarref\Jwt\Token\Header\Parameter;
use Emarref\Jwt\Token\Payload\Claim;
use Emarref\Jwt\Token\PropertyList;

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
     * @param Parameter\ParameterInterface $parameter
     */
    public function setParameter(Parameter\ParameterInterface $parameter)
    {
        $this->propertyList->setProperty($parameter);
    }

    /**
     * @param Claim\ClaimInterface $claim
     */
    public function addCriticalClaim(Claim\ClaimInterface $claim)
    {
        $criticalParameter = $this->findPropertyByName(Parameter\CriticalParameter::NAME);

        if (!$criticalParameter) {
            $criticalParameter = new Parameter\CriticalParameter();
        }

        $criticalParameter->addClaim($claim);
        $this->setParameter($criticalParameter);
    }

    /**
     * @param string $name
     * @return Parameter\ParameterInterface|null
     */
    public function findPropertyByName($name)
    {
        foreach ($this->propertyList as $parameter) {
            /** @var Parameter\ParameterInterface $parameter */
            if ($parameter->getName() === $name) {
                return $parameter;
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

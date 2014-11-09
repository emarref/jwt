<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Claim;

class Header implements \JsonSerializable
{
    /**
     * @var PropertyList
     */
    protected $propertyList;

    public function __construct()
    {
        $this->propertyList = new PropertyList();
    }

    /**
     * @param HeaderParameter\ParameterInterface $parameter
     * @param boolean                            $critical
     */
    public function setParameter(HeaderParameter\ParameterInterface $parameter, $critical = false)
    {
        $this->propertyList->setProperty($parameter);

        if ($critical) {
            /** @var HeaderParameter\Critical $criticalParameter */
            $criticalParameter = $this->findParameterByName(HeaderParameter\Critical::NAME);

            if (!$criticalParameter) {
                $criticalParameter = new HeaderParameter\Critical();
            }

            $criticalParameter->addParameter($parameter);
            $this->propertyList->setProperty($criticalParameter);
        }
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
     * @return PropertyList
     */
    public function getParameters()
    {
        return $this->propertyList;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->propertyList->jsonSerialize();
    }
}

<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\HeaderParameter;

class Header extends AbstractTokenBody
{
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
}

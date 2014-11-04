<?php

namespace Emarref\Jwt\Token;

use Traversable;

class PropertyList implements \JsonSerializable, \IteratorAggregate
{
    /**
     * @var \ArrayObject
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new \ArrayObject();
    }

    /**
     * @param string $name
     */
    public function removeProperty($name)
    {
        unset($this->properties[$name]);
    }

    /**
     * @param PropertyInterface $property
     */
    public function setProperty(PropertyInterface $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        $properties = new \stdClass();

        foreach ($this->properties as $property) {
            $name  = $property->getName();
            $value = $property->getValue();

            if (empty($name) || empty($value)) {
                continue;
            }

            $properties->$name = $value;
        }

        return json_encode($properties);
    }

    /**
     * @return PropertyInterface[]
     */
    public function getIterator()
    {
        return $this->properties;
    }
}

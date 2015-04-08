<?php

namespace Emarref\Jwt\Token;

class PropertyList implements \JsonSerializable, \IteratorAggregate
{
    /**
     * @var \ArrayObject
     */
    protected $properties;

    public function __construct()
    {
        $this->properties = new \ArrayObject();
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
    public function jsonSerialize()
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

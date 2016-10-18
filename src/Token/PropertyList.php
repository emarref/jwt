<?php

namespace Emarref\Jwt\Token;

class PropertyList implements \JsonSerializable, \IteratorAggregate
{
    /**
     * @var \ArrayObject
     */
    protected $properties;

    /**
     * @var int
     */
    private $jsonOptions;

    /**
     * @param int|null $jsonOptions Options to be passed to the json_encode function.
     */
    public function __construct($jsonOptions = null)
    {
        $this->properties = new \ArrayObject();
        $this->jsonOptions = $jsonOptions;
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

        return json_encode($properties, $this->jsonOptions);
    }

    /**
     * @return PropertyInterface[]
     */
    public function getIterator()
    {
        return $this->properties;
    }
}

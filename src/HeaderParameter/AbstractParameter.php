<?php

namespace Emarref\Jwt\HeaderParameter;

abstract class AbstractParameter implements ParameterInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value = null)
    {
        $this->setValue($value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
} 

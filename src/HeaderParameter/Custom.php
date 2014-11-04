<?php

namespace Emarref\Jwt\HeaderParameter;

class Custom extends AbstractParameter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param mixed $name
     * @param mixed $value
     */
    public function __construct($name = null, $value = null)
    {
        parent::__construct($value);

        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}

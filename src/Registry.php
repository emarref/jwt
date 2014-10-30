<?php

namespace Emarref\Jwt;

abstract class Registry
{
    /**
     * @var array
     */
    private $registry;

    /**
     * @param string $name
     * @param string $class
     * @throws \InvalidArgumentException
     */
    public function register($name, $class)
    {
        $requiredInterface = $this->getRequiredInterface();

        if (!is_a($class, $requiredInterface, true)) {
            throw new \InvalidArgumentException(sprintf(
                'Class "%s" must implement %s to be registered.',
                $class,
                $requiredInterface
            ));
        }

        $this->registry[$name] = $class;
    }

    /**
     * @param string $name
     * @return object
     */
    public function resolve($name)
    {
        if (isset($this->registry[$name])) {
            $class = $this->registry[$name];
        } else {
            $class = $this->getDefaultClass();
        }

        return new $class($name);
    }

    /**
     * @return string
     */
    abstract public function getRequiredInterface();

    /**
     * @return string
     */
    abstract public function getDefaultClass();
}

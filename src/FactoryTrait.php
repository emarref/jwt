<?php

namespace Emarref\Jwt;

trait FactoryTrait
{
    /**
     * @return string
     */
    abstract protected function getClassMap();

    /**
     * @return string
     */
    abstract protected function getDefaultClass();

    /**
     * @param string $name
     * @return object
     */
    public function get($name)
    {
        $classMap     = $this->getClassMap();
        $defaultClass = $this->getDefaultClass();

        if (isset($classMap[$name])) {
            $class = $classMap[$name];
            $parameter = new $class();
        } else {
            $class = $defaultClass;
            $parameter = new $class($name);
        }

        return $parameter;
    }
}

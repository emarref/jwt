<?php

namespace Emarref\Jwt\Token\Header\Parameter;

use Emarref\Jwt\Registry as BaseRegistry;

/**
 * @method ParameterInterface resolve(string $name)
 */
class Registry extends BaseRegistry
{
    const REQUIRED_INTERFACE      = 'Emarref\Jwt\Token\Header\Parameter\ParameterInterface';
    const DEFAULT_PARAMETER_CLASS = 'Emarref\Jwt\Token\header\Parameter\Parameter';

    /**
     * @return string
     */
    public function getRequiredInterface()
    {
        return self::REQUIRED_INTERFACE;
    }

    /**
     * @return string
     */
    public function getDefaultClass()
    {
        return self::DEFAULT_PARAMETER_CLASS;
    }
} 

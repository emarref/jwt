<?php

namespace Emarref\Jwt\Token;

interface PropertyInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed
     */
    public function setValue($value);
} 

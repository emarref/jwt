<?php

namespace Emarref\Jwt\Token;

class PayloadStub extends Payload
{
    /**
     * @param PropertyList $propertyList
     */
    public function __construct(PropertyList $propertyList)
    {
        $this->propertyList = $propertyList;
    }
}

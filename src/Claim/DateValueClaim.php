<?php

namespace Emarref\Jwt\Claim;

abstract class DateValueClaim extends AbstractClaim
{
    /**
     * @param \DateTime|string $value
     */
    public function setValue($value)
    {
        if ($value instanceof \DateTime) {
            $value->setTimezone(new \DateTimeZone('UTC'));
            $value = $value->getTimestamp();
        }

        parent::setValue($value);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return parent::getValue();
    }
}

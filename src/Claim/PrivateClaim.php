<?php

namespace Emarref\Jwt\Claim;

/**
 * Private Claim
 *
 * A producer and consumer of a JWT MAY agree to use Claim Names that are Private Names: names that are not Registered
 * Claim Names Section 4.1 or Public Claim Names Section 4.2. Unlike Public Claim Names, Private Claim Names are subject
 * to collision and should be used with caution.
 */
class PrivateClaim extends AbstractClaim
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
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

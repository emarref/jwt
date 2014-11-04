<?php

namespace Emarref\Jwt\Claim;

/**
 * Public Claim
 *
 * Claim Names can be defined at will by those using JWTs. However, in order to prevent collisions, any new Claim Name
 * should either be registered in the IANA JSON Web Token Claims registry defined in Section 10.1 or be a Public Name: a
 * value that contains a Collision-Resistant Name. In each case, the definer of the name or value needs to take
 * reasonable precautions to make sure they are in control of the part of the namespace they use to define the Claim
 * Name.
 */
class PublicClaim extends AbstractClaim
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

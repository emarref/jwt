<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Algorithm\AlgorithmInterface;

class Context
{
    /**
     * @var string
     */
    private $audience;

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var AlgorithmInterface
     */
    private $algorithm;

    /**
     * @return string
     */
    public function getAudience()
    {
        return $this->audience;
    }

    /**
     * @param string $audience
     * @return $this
     */
    public function setAudience($audience)
    {
        $this->audience = $audience;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     * @return $this
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
        return $this;
    }

    /**
     * @return AlgorithmInterface
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param AlgorithmInterface $algorithm
     * @return $this
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
        return $this;
    }
}

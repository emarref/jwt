<?php

namespace Emarref\Jwt\Exception;

class ExpiredException extends VerificationException
{
    /**
     * @var \DateTime
     */
    private $expiredAt;

    public function __construct(\DateTime $expiredAt, $code = 0, \Exception $previous = null) {
        $this->expiredAt = $expiredAt;
        $message = sprintf('Token expired at "%s"', $expiredAt->format('r'));
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }
}

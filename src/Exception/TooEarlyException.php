<?php

namespace Emarref\Jwt\Exception;

class TooEarlyException extends VerificationException
{
    /**
     * @var \DateTime
     */
    private $validFrom;

    public function __construct(\DateTime $validFrom, $code = 0, \Exception $previous = null) {
        $this->validFrom = $validFrom;
        $message = sprintf('Token must not be processed before "%s"', $validFrom->format('r'));
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return \DateTime
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }
}

<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Encryption\EncryptionInterface;

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
     * @var string
     */
    private $subject;

    /**
     * @var EncryptionInterface
     */
    private $encryption;

    /**
     * @param EncryptionInterface $encryption
     */
    public function __construct(EncryptionInterface $encryption)
    {
        $this->setEncryption($encryption);
    }

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
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return EncryptionInterface
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * @param EncryptionInterface $encryption
     * @return $this
     */
    public function setEncryption($encryption)
    {
        $this->encryption = $encryption;
        return $this;
    }
}

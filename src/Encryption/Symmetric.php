<?php

namespace Emarref\Jwt\Encryption;

use Emarref\Jwt\Algorithm;

/**
 * @property Algorithm\SymmetricInterface $algorithm
 */
class Symmetric extends AbstractEncryption implements EncryptionInterface
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @param Algorithm\SymmetricInterface $algorithm
     */
    public function __construct(Algorithm\SymmetricInterface $algorithm)
    {
        parent::__construct($algorithm);
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @param string $value
     * @return string
     */
    public function encrypt($value)
    {
        return $this->algorithm->compute($value);
    }

    /**
     * @param string $value
     * @param string $signature
     * @return boolean
     */
    public function verify($value, $signature)
    {
        $computedValue = $this->algorithm->compute($value);

        return $this->timingSafeEquals($signature, $computedValue);
    }

    /**
     * A timing safe equals comparison.
     *
     * @see http://blog.ircmaxell.com/2014/11/its-all-about-time.html
     *
     * @param string $safe The internal (safe) value to be checked
     * @param string $user The user submitted (unsafe) value
     *
     * @return boolean True if the two strings are identical.
     */
    public function timingSafeEquals($safe, $user)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($user, $safe);
        }

        $safeLen = strlen($safe);
        $userLen = strlen($user);

        /*
         * In general, it's not possible to prevent length leaks. So it's OK to leak the length.
         * @see http://security.stackexchange.com/questions/49849/timing-safe-string-comparison-avoiding-length-leak
         */
        if ($userLen != $safeLen) {
            return false;
        }

        $result = 0;

        for ($i = 0; $i < $userLen; $i++) {
            $result |= (ord($safe[$i]) ^ ord($user[$i]));
        }

        return $result === 0;
    }
}

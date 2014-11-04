<?php

namespace Emarref\Jwt\Encoding;

class Base64 implements EncoderInterface
{
    /**
     * @var boolean
     */
    private $urlSafe;

    /**
     * @var boolean
     */
    private $strict;

    /**
     * @var array
     */
    private static $urlSafeReplacements = [
        '+' => '-',
        '/' => '_'
    ];

    /**
     * @param boolean $urlSafe
     * @param boolean $strict
     */
    public function __construct($urlSafe = true, $strict = true)
    {
        $this->urlSafe = (boolean)$urlSafe;
        $this->strict  = (boolean)$strict;
    }

    /**
     * Return a URL-safe representation of a base64-encoded value.
     *
     * @param string $value
     * @return string
     */
    protected function urlEncode($value)
    {
        return strtr(rtrim($value, '='), self::$urlSafeReplacements);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function urlDecode($value)
    {
        $urlUnsafeReplacements = array_flip(self::$urlSafeReplacements);

        $value = strtr($value, $urlUnsafeReplacements);

        switch (strlen($value) % 4) {
            case 0:
                // No pad chars in this case
                break;
            case 2:
                $value .= '==';
                break;
            case 3:
                $value .= '=';
                break;
            case 1:
            default:
                throw new \RuntimeException('Value could not be decoded from URL safe representation.');
        }

        return $value;
    }

    /**
     * @param string $value
     * @return string
     */
    public function encode($value)
    {
        if (empty($value)) {
            return '';
        }

        $encoded = base64_encode($value);

        if ($this->urlSafe) {
            $encoded = $this->urlEncode($encoded);
        }

        return $encoded;
    }

    /**
     * @param string $value
     * @return string
     */
    public function decode($value)
    {
        if (empty($value)) {
            return $value;
        }

        if ($this->urlSafe) {
            $decoded = $this->urlDecode($value);
        } else {
            $decoded = $value;
        }

        $decoded = base64_decode($decoded, $this->strict);

        return $decoded;
    }
}

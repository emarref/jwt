<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Claim;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token\AbstractTokenBody;
use Emarref\Jwt\Token\Header;
use Emarref\Jwt\Token\Payload;

class Token
{
    const OPT_JSON_ESCAPE_SLASHES = 'json_escape_slashes';

    /**
     * @var Header
     */
    private $header;

    /**
     * @var Payload
     */
    private $payload;

    /**
     * @var string
     */
    private $signature;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options = $this->parseOptions($options);

        $sectionOptions = [];

        if (false === (bool)$options[self::OPT_JSON_ESCAPE_SLASHES]) {
            $sectionOptions = [
                AbstractTokenBody::OPT_JSON_OPTIONS => JSON_UNESCAPED_SLASHES
            ];
        }

        $this->header  = new Header($sectionOptions);
        $this->payload = new Payload($sectionOptions);
    }

    /**
     * @param array $options
     * @return array
     */
    protected function parseOptions(array $options)
    {
        $defaultOptions = $this->getDefaultOptions();

        return array_merge($defaultOptions, $options);
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
            self::OPT_JSON_ESCAPE_SLASHES => false,
        ];
    }

    /**
     * @param HeaderParameter\ParameterInterface $parameter
     * @param bool                               $critical
     */
    public function addHeader(HeaderParameter\ParameterInterface $parameter, $critical = false)
    {
        $this->header->setParameter($parameter, $critical);
    }

    /**
     * @param Claim\ClaimInterface $claim
     */
    public function addClaim(Claim\ClaimInterface $claim)
    {
        $this->payload->setClaim($claim);
    }

    /**
     * @return Token\Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return Token\Payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }
}

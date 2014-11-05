<?php

namespace Emarref\Jwt\Serialization;

use Emarref\Jwt\Claim;
use Emarref\Jwt\Encoding;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token;

class Compact implements SerializerInterface
{
    /**
     * @var Encoding\EncoderInterface
     */
    private $encoding;

    /**
     * @var HeaderParameter\Factory
     */
    private $headerParameterFactory;

    /**
     * @var Claim\Factory
     */
    private $claimFactory;

    /**
     * @param Encoding\EncoderInterface $encoding
     * @param HeaderParameter\Factory $headerParameterFactory
     * @param Claim\Factory $claimFactory
     */
    public function __construct(
        Encoding\EncoderInterface $encoding,
        HeaderParameter\Factory $headerParameterFactory,
        Claim\Factory $claimFactory
    ) {
        $this->encoding               = $encoding;
        $this->headerParameterFactory = $headerParameterFactory;
        $this->claimFactory           = $claimFactory;
    }

    /**
     * @param string $headersJson
     * @return HeaderParameter\ParameterInterface[]
     */
    protected function parseHeaders($headersJson)
    {
        $parameters = [];
        $headers = json_decode($headersJson, true);

        foreach ($headers as $name => $value) {
            $parameter = $this->headerParameterFactory->get($name);
            $parameter->setValue($value);
            $parameters[] = $parameter;
        }

        return  $parameters;
    }

    /**
     * @param string $payloadJson
     * @return Claim\ClaimInterface[]
     */
    protected function parsePayload($payloadJson)
    {
        $claims = [];
        $payload = json_decode($payloadJson, true);

        foreach ($payload as $name => $value) {
            $claim = $this->claimFactory->get($name);
            $claim->setValue($value);
            $claims[] = $claim;
        }

        return $claims;
    }

    /**
     * @param string $jwt
     * @return Token
     */
    public function deserialize($jwt)
    {
        $token = new Token();

        list($encodedHeader, $encodedPayload, $encodedSignature) = explode('.', $jwt);

        $decodedHeader    = $this->encoding->decode($encodedHeader);
        $decodedPayload   = $this->encoding->decode($encodedPayload);
        $decodedSignature = $this->encoding->decode($encodedSignature);

        foreach ($this->parseHeaders($decodedHeader) as $header) {
            $token->addHeader($header);
        }

        foreach ($this->parsePayload($decodedPayload) as $claim) {
            $token->addClaim($claim);
        }

        $token->setSignature($decodedSignature);

        return $token;
    }

    /**
     * @param Token $token
     * @return string
     */
    public function serialize(Token $token)
    {
        $serializedHeader  = $token->getHeader()->getParameters()->jsonSerialize();
        $serializedPayload = $token->getPayload()->getClaims()->jsonSerialize();
        $signature         = $token->getSignature();

        return sprintf('%s.%s.%s',
            $this->encoding->encode($serializedHeader),
            $this->encoding->encode($serializedPayload),
            $this->encoding->encode($signature)
        );
    }
}

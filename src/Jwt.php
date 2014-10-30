<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Encoding;
use Emarref\Jwt\Encryption\Strategy as EncryptionStrategy;
use Emarref\Jwt\Token\Header\Parameter;
use Emarref\Jwt\Token\Payload\Claim;
use Emarref\Jwt\Token\Token;

class Jwt
{
    private static $knownParameters = [
        Parameter\AlgorithmParameter::NAME                       => 'Emarref\Jwt\Token\Header\Parameter\AlgorithmParameter',
        Parameter\ContentTypeParameter::NAME                     => 'Emarref\Jwt\Token\Header\Parameter\ContentTypeParameter',
        Parameter\CriticalParameter::NAME                        => 'Emarref\Jwt\Token\Header\Parameter\CriticalParameter',
        Parameter\JsonWebKeyParameter::NAME                      => 'Emarref\Jwt\Token\Header\Parameter\JsonWebKeyParameter',
        Parameter\JwkSetUrlParameter::NAME                       => 'Emarref\Jwt\Token\Header\Parameter\JwkSetUrlParameter',
        Parameter\KeyIdParameter::NAME                           => 'Emarref\Jwt\Token\Header\Parameter\KeyIdParameter',
        Parameter\TypeParameter::NAME                            => 'Emarref\Jwt\Token\Header\Parameter\TypeParameter',
        Parameter\X509CertificateChainParameter::NAME            => 'Emarref\Jwt\Token\Header\Parameter\X509CertificateChainParameter',
        Parameter\X509CertificateSha1ThumbprintParameter::NAME   => 'Emarref\Jwt\Token\Header\Parameter\X509CertificateSha1ThumbprintParameter',
        Parameter\X509CertificateSha256ThumbprintParameter::NAME => 'Emarref\Jwt\Token\Header\Parameter\X509CertificateSha256ThumbprintParameter',
        Parameter\X509UrlParameter::NAME                         => 'Emarref\Jwt\Token\Header\Parameter\X509UrlParameter',
    ];

    private static $knownClaims = [
        Claim\AudienceClaim::NAME   => 'Emarref\Jwt\Token\Payload\Claim\AudienceClaim',
        Claim\ExpirationClaim::NAME => 'Emarref\Jwt\Token\Payload\Claim\ExpirationClaim',
        Claim\IssuedAtClaim::NAME   => 'Emarref\Jwt\Token\Payload\Claim\IssuedAtClaim',
        Claim\IssuerClaim::NAME     => 'Emarref\Jwt\Token\Payload\Claim\IssuerClaim',
        Claim\JwtIdClaim::NAME      => 'Emarref\Jwt\Token\Payload\Claim\JwtIdClaim',
        Claim\NotBeforeClaim::NAME  => 'Emarref\Jwt\Token\Payload\Claim\NotBeforeClaim',
        Claim\SubjectClaim::NAME    => 'Emarref\Jwt\Token\Payload\Claim\SubjectClaim',
    ];

    /**
     * @var Encoding\EncoderInterface
     */
    private $encoder;

    /**
     * @var Parameter\Registry
     */
    private $parameterRegistry;

    /**
     * @var Claim\Registry
     */
    private $claimRegistry;

    /**
     * @var EncryptionStrategy\EncryptionStrategyInterface[]
     */
    private $encryptionStrategies = [];

    /**
     * @param Encoding\EncoderInterface $encoder
     */
    public function __construct(Encoding\EncoderInterface $encoder = null)
    {
        if (null === $encoder) {
            $encoder = new Encoding\Base64();
        }

        $this->encoder = $encoder;

        $this->initParameterRegistry();
        $this->initClaimRegistry();
        $this->initEncryptionStrategies();
    }

    private function initParameterRegistry()
    {
        $this->parameterRegistry = new Parameter\Registry();

        foreach (self::$knownParameters as $name => $class) {
            $this->parameterRegistry->register($name, $class);
        }
    }

    /**
     * @return Parameter\Registry
     */
    public function getParameterRegistry()
    {
        return $this->parameterRegistry;
    }

    private function initClaimRegistry()
    {
        $this->claimRegistry = new Claim\Registry();

        foreach (self::$knownClaims as $name => $class) {
            $this->claimRegistry->register($name, $class);
        }
    }

    /**
     * @return Claim\Registry
     */
    public function getClaimRegistry()
    {
        return $this->claimRegistry;
    }

    public function initEncryptionStrategies()
    {
        $this->registerEncryptionStrategy(new EncryptionStrategy\None());
    }

    /**
     * @param EncryptionStrategy\EncryptionStrategyInterface $encryptionStrategy
     * @throws \InvalidArgumentException
     */
    public function registerEncryptionStrategy(EncryptionStrategy\EncryptionStrategyInterface $encryptionStrategy)
    {
        if (isset($this->encryptionStrategies[$encryptionStrategy->getName()])) {
            throw new \InvalidArgumentException(sprintf(
                'Encryption strategy "%s" is already registered.',
                $encryptionStrategy->getName()
            ));
        }

        $this->encryptionStrategies[$encryptionStrategy->getName()] = $encryptionStrategy;
    }

    /**
     * @return Token
     */
    public function createToken()
    {
        return new Token();
    }

    /**
     * @param Token $token
     * @param EncryptionStrategy\EncryptionStrategyInterface|string|null $encryptionStrategy
     * @return string
     */
    public function encode(Token $token, EncryptionStrategy\EncryptionStrategyInterface $encryptionStrategy = null)
    {
        if (!$encryptionStrategy instanceof EncryptionStrategy\EncryptionStrategyInterface) {
            $encryptionStrategy = $this->resolveEncryptionStrategy($encryptionStrategy);
        }

        $header  = clone $token->getHeader();
        $header->setParameter(new Parameter\AlgorithmParameter($encryptionStrategy->getName()));
        $header = $header->jsonSerialize();

        $payload = $token->getPayload()->jsonSerialize();

        $signature = $encryptionStrategy->encrypt(sprintf(
            '%s.%s',
            $this->encoder->encode($header),
            $this->encoder->encode($payload)
        ));

        return sprintf('%s.%s.%s',
            $this->encoder->encode($header),
            $this->encoder->encode($payload),
            $this->encoder->encode($signature)
        );
    }

    /**
     * @param string $encodedToken
     * @param EncryptionStrategy\EncryptionStrategyInterface|string|null $encryptionStrategy
     * @param boolean $verify
     * @return Token;
     */
    public function decode($encodedToken, $encryptionStrategy = null, $verify = true)
    {
        $encodedTokenParts = explode('.', $encodedToken);

        if (3 !== count($encodedTokenParts)) {
            throw new \InvalidArgumentException('Token could not be decoded.');
        }

        list($encodedHeader, $encodedPayload, $encodedSignature) = $encodedTokenParts;

        $token = new Token();

        foreach ($this->parseTokenPart($encodedHeader, $this->parameterRegistry) as $parameter) {
            $token->getHeader()->setParameter($parameter);
        }

        foreach ($this->parseTokenPart($encodedPayload, $this->claimRegistry) as $claim) {
            $token->addClaim($claim);
        }

        $algorithm = $this->resolveAlgorithmFromToken($token);

        if (null === $algorithm) {
            throw new \RuntimeException('No algorithm found in header.');
        }

        if (!$encryptionStrategy instanceof EncryptionStrategy\EncryptionStrategyInterface) {
            $encryptionStrategy = $this->resolveEncryptionStrategy($encryptionStrategy ?: $algorithm->getValue());
        }

        if ($algorithm->getValue() !== $encryptionStrategy->getName()) {
            throw new \RuntimeException(sprintf(
                'Cannot decode "%s" encrypted token with "%s" strategy.',
                $algorithm->getValue(),
                $encryptionStrategy->getName()
            ));
        }

        if ($verify) {
            $this->verify($token);
        }

        return $token;
    }

    /**
     * @return EncryptionStrategy\EncryptionStrategyInterface
     */
    private function getDefaultEncryptionStrategy()
    {
        return $this->encryptionStrategies[EncryptionStrategy\None::NAME];
    }

    /**
     * @param Token $token
     * @return Parameter\AlgorithmParameter|null
     */
    protected function resolveAlgorithmFromToken(Token $token)
    {
        /** @var Parameter\AlgorithmParameter $algorithm */
        return $token->getHeader()->findParameterByName(Parameter\AlgorithmParameter::NAME);
    }

    /**
     * @param string|null $encryptionStrategy
     * @return EncryptionStrategy\EncryptionStrategyInterface
     */
    protected function resolveEncryptionStrategy($encryptionStrategy = null)
    {
        if (null === $encryptionStrategy) {
            return $this->getDefaultEncryptionStrategy();
        } elseif (!is_string($encryptionStrategy)) {
            throw new \RuntimeException('Can not determine encryption strategy.');
        }

        if (!isset($this->encryptionStrategies[$encryptionStrategy])) {
            throw new \RuntimeException(sprintf('Encryption strategy "%s" is not configured.', $encryptionStrategy));
        }

        return $this->encryptionStrategies[$encryptionStrategy];
    }

    /**
     * @param string   $encoded
     * @param Registry $registry
     * @return array
     */
    protected function parseTokenPart($encoded, Registry $registry)
    {
        $results = [];
        $decoded = $this->encoder->decode($encoded);
        $array   = json_decode($decoded, true);

        if (!$array) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        foreach ($array as $name => $value) {
            $entry = $registry->resolve($name);
            $entry->setValue($value);
            $results[] = $entry;
        }

        return $results;
    }

    public function verify(Token $token)
    {
        // Todo
    }
}

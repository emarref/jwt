<?php

namespace Emarref\Jwt;

use Emarref\Jwt\Encoding;
use Emarref\Jwt\Encryption;
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
     * @var Encryption\StrategyInterface[]
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
        $this->registerEncryptionStrategy(new Encryption\None());
    }

    /**
     * @param Encryption\StrategyInterface $strategy
     * @throws \InvalidArgumentException
     */
    public function registerEncryptionStrategy(Encryption\StrategyInterface $strategy)
    {
        if (isset($this->encryptionStrategies[$strategy->getName()])) {
            throw new \InvalidArgumentException(sprintf(
                'Encryption strategy "%s" is already registered.',
                $strategy->getName()
            ));
        }

        $this->encryptionStrategies[$strategy->getName()] = $strategy;
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
     * @param Encryption\StrategyInterface|string|null $encryption
     * @return string
     */
    public function encode(Token $token, $encryption = null)
    {
        if (!$encryption instanceof Encryption\StrategyInterface) {
            $encryption = $this->resolveEncryptionStrategy($encryption);
        }

        $header = $token->getHeader();
        $header->setParameter(new Parameter\AlgorithmParameter($encryption->getName()));
        $header = $header->jsonSerialize();

        $payload = $token->getPayload()->jsonSerialize();

        $signature = $encryption->encrypt(sprintf(
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
     * @param Encryption\StrategyInterface|string|null $encryptionStrategy
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

        if (!$encryptionStrategy instanceof Encryption\StrategyInterface) {
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
     * @return Encryption\StrategyInterface
     */
    private function getDefaultEncryptionStrategy()
    {
        return $this->encryptionStrategies[Encryption\None::NAME];
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
     * @param string|null $strategy
     * @return Encryption\StrategyInterface
     */
    protected function resolveEncryptionStrategy($strategy = null)
    {
        if (null === $strategy) {
            return $this->getDefaultEncryptionStrategy();
        } elseif (!is_string($strategy)) {
            throw new \RuntimeException('Can not determine encryption strategy.');
        }

        if (!isset($this->encryptionStrategies[$strategy])) {
            throw new \RuntimeException(sprintf('Encryption strategy "%s" is not configured.', $strategy));
        }

        return $this->encryptionStrategies[$strategy];
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

        if (null === $array) {
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

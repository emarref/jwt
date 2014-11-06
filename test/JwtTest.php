<?php

use Emarref\Jwt\Algorithm\AlgorithmInterface;
use Emarref\Jwt\Algorithm\Hs256;
use Emarref\Jwt\Algorithm\Rs256;
use Emarref\Jwt\Algorithm\SslKeyPairTrait;
use Emarref\Jwt\Jwt;
use Emarref\Jwt\Token;
use Emarref\Jwt\Claim;
use Emarref\Jwt\Verification;

require_once dirname(__FILE__).'/Algorithm/SslKeyPairTrait.php';

class JwtTest extends \PHPUnit_Framework_TestCase
{
    use SslKeyPairTrait;

    public function testVerifyWithSymmetricAlgorithm()
    {
        //serialialize a token
        $jwtHandler = new Jwt();
        $algorithm = new Hs256();
        $secret = 'test';
        $issuer = 'uri://foobar';
        $jwt = $this->getSampleEncodedToken($jwtHandler, $algorithm, $secret, $issuer);

        //deserialize it
        $token = $jwtHandler->deserialize($jwt);

        $context = new Verification\Context();
        $context->setAlgorithm($algorithm);
        $context->setVerificationKey($secret);
        $context->setIssuer($issuer);
        $this->assertTrue($jwtHandler->verify($token, $context));
    }

    public function testVerifyWithAsymmetricAlgorithm()
    {
        //serialialize a token
        $jwtHandler = new Jwt();
        $algorithm = new Rs256();
        $issuer = 'uri://foobar';
        $keyPair = $this->generateKeyPair('sha256');
        $jwt = $this->getSampleEncodedToken($jwtHandler, $algorithm, $keyPair['private'], $issuer);

        //deserialize it
        $token = $jwtHandler->deserialize($jwt);

        $context = new Verification\Context();
        $context->setAlgorithm($algorithm);
        $context->setVerificationKey($keyPair['public']);
        $context->setIssuer($issuer);
        $this->assertTrue($jwtHandler->verify($token, $context));
    }

    private function getSampleEncodedToken(Jwt $jwtHandler, AlgorithmInterface $algorithm, $signingKey, $issuer)
    {
        $token = new Token();
        $token->addClaim(new Claim\Issuer($issuer));
        $token->addClaim(new Claim\Expiration(new \DateTime('30 minutes')));
        $jwt = $jwtHandler->serialize($token, $algorithm, $signingKey);
        return $jwt;
    }

}
 
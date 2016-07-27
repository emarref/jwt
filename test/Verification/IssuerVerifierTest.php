<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;

class IssuerVerifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Emarref\Jwt\Token\Payload
     */
    private $payload;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Emarref\Jwt\Token
     */
    private $token;

    public function setUp()
    {
        $this->payload = $this->getMockBuilder('Emarref\Jwt\Token\Payload')->getMock();

        $this->token = $this->getMockBuilder('Emarref\Jwt\Token')->getMock();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Cannot verify invalid issuer value.
     */
    public function testInvalidIssuer()
    {
        new IssuerVerifier(new \stdClass());
    }

    public function testNoIssuer()
    {
        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Issuer::NAME)
            ->will($this->returnValue(null));

        $verifier = new IssuerVerifier();
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidIssuerException
     * @expectedExceptionMessage Issuer is invalid.
     */
    public function testIssuerInPayloadOnly()
    {
        $issuerClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Issuer')
            ->getMock();

        $issuerClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('an_issuer'));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Issuer::NAME)
            ->will($this->returnValue($issuerClaim));

        $verifier = new IssuerVerifier();
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidIssuerException
     * @expectedExceptionMessage Issuer is invalid.
     */
    public function testIssuerInContextOnly()
    {
        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Issuer::NAME)
            ->will($this->returnValue(null));

        $verifier = new IssuerVerifier('an_issuer');
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidIssuerException
     * @expectedExceptionMessage Issuer is invalid.
     */
    public function testIssuerMismatch()
    {
        $issuerClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Issuer')
            ->getMock();

        $issuerClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('an_issuer'));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Issuer::NAME)
            ->will($this->returnValue($issuerClaim));

        $verifier = new IssuerVerifier('some_other_issuer');
        $verifier->verify($this->token);
    }

    public function testSuccess()
    {
        $issuerClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Issuer')
            ->getMock();

        $issuerClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('an_issuer'));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Issuer::NAME)
            ->will($this->returnValue($issuerClaim));

        $verifier = new IssuerVerifier('an_issuer');
        $verifier->verify($this->token);
    }
}

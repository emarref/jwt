<?php

namespace Emarref\Jwt\Verification;

class ExpirationVerifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Emarref\Jwt\Token\Payload
     */
    private $payload;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Emarref\Jwt\Token
     */
    private $token;

    /**
     * @var ExpirationVerifier
     */
    private $verifier;

    public function setUp()
    {
        $this->payload = $this->getMockBuilder('Emarref\Jwt\Token\Payload')->getMock();

        $this->token = $this->getMockBuilder('Emarref\Jwt\Token')->getMock();

        $this->token->expects($this->any())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->verifier = new ExpirationVerifier();
    }

    public function testMissingExpiry()
    {
        $this->payload->expects($this->once())
                      ->method('findClaimByName')
                      ->will($this->returnValue(null));

        $this->verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\ExpiredException
     * @expectedExceptionMessage Token expired at "Sat, 08 Nov 2014 00:00:00 +0000"
     */
    public function testExpired()
    {
        $dateTime = new \DateTime('Sat, 08 Nov 2014 00:00:00 +0000');

        $expirationClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Expiration')->getMock();

        $expirationClaim->expects($this->exactly(3))
            ->method('getValue')
            ->will($this->returnValue($dateTime->getTimestamp()));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->will($this->returnValue($expirationClaim));

        $this->verifier->verify($this->token);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid expiration timestamp "foobar"
     */
    public function testUnexpectedValue()
    {
        $expirationClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Expiration')->getMock();

        $expirationClaim->expects($this->exactly(3))
                        ->method('getValue')
                        ->will($this->returnValue('foobar'));

        $this->payload->expects($this->once())
                      ->method('findClaimByName')
                      ->will($this->returnValue($expirationClaim));

        $this->verifier->verify($this->token);
    }

    public function testValid()
    {
        $future = new \DateTime('5 minutes', new \DateTimeZone('UTC'));

        $expirationClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Expiration')->getMock();

        $expirationClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue($future->getTimestamp()));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->will($this->returnValue($expirationClaim));

        $this->verifier->verify($this->token);
    }
}

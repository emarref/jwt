<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;

class AudienceVerifierTest extends \PHPUnit_Framework_TestCase
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
     * @expectedExceptionMessage Cannot verify invalid audience value.
     */
    public function testInvalidAudience()
    {
        new AudienceVerifier(new \stdClass());
    }

    public function testNoAudienceInToken()
    {
        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Audience::NAME)
            ->will($this->returnValue(null));

        $verifier = new AudienceVerifier();
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidAudienceException
     * @expectedExceptionMessage Audience is invalid.
     */
    public function testInvalidAudienceInToken()
    {
        $expectedAudience = 'urn://myaudience';

        $audienceClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Audience')->getMock();

        $audienceClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue($expectedAudience));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Audience::NAME)
            ->will($this->returnValue($audienceClaim));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $verifier = new AudienceVerifier('foobar');
        $verifier->verify($this->token);
    }

    public function testArrayAudience()
    {
        $audienceClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Audience')->getMock();

        $audienceClaim->expects($this->once())
                      ->method('getValue')
                      ->will($this->returnValue(['urn://audienceone', 'urn://audiencetwo']));

        $this->payload->expects($this->once())
                      ->method('findClaimByName')
                      ->with(Claim\Audience::NAME)
                      ->will($this->returnValue($audienceClaim));

        $this->token->expects($this->once())
                    ->method('getPayload')
                    ->will($this->returnValue($this->payload));

        $verifier = new AudienceVerifier('urn://audienceone');
        $verifier->verify($this->token);
    }

    public function testStringAudience()
    {
        $audienceClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Audience')->getMock();

        $audienceClaim->expects($this->once())
                      ->method('getValue')
                      ->will($this->returnValue('urn://audienceone'));

        $this->payload->expects($this->once())
                      ->method('findClaimByName')
                      ->with(Claim\Audience::NAME)
                      ->will($this->returnValue($audienceClaim));

        $this->token->expects($this->once())
                    ->method('getPayload')
                    ->will($this->returnValue($this->payload));

        $verifier = new AudienceVerifier('urn://audienceone');
        $verifier->verify($this->token);
    }
}

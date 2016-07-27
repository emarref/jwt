<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim\NotBefore;

class NotBeforeVerifierTest extends \PHPUnit_Framework_TestCase
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
     * @var NotBeforeVerifier
     */
    private $verifier;

    public function setUp()
    {
        $this->payload = $this->getMockBuilder('Emarref\Jwt\Token\Payload')->getMock();

        $this->token = $this->getMockBuilder('Emarref\Jwt\Token')->getMock();

        $this->token->expects($this->any())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->verifier = new NotBeforeVerifier();
    }

    public function testMissingNotBefore()
    {
        $this->payload->expects($this->once())
                      ->method('findClaimByName')
                      ->with(NotBefore::NAME)
                      ->will($this->returnValue(null));

        $this->verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\TooEarlyException
     * @expectedExceptionMessageRegExp /Token must not be processed before "[\w,:+\d ]+"/
     */
    public function testNotBefore()
    {
        $dateTime = new \DateTime('1 day');

        $notBeforeClaim = $this->getMockBuilder('Emarref\Jwt\Claim\NotBefore')->getMock();

        $notBeforeClaim->expects($this->exactly(3))
            ->method('getValue')
            ->will($this->returnValue($dateTime->getTimestamp()));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(NotBefore::NAME)
            ->will($this->returnValue($notBeforeClaim));

        $this->verifier->verify($this->token);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid not before timestamp "foobar"
     */
    public function testUnexpectedValue()
    {
        $notBeforeClaim = $this->getMockBuilder('Emarref\Jwt\Claim\NotBefore')->getMock();

        $notBeforeClaim->expects($this->exactly(2))
                        ->method('getValue')
                        ->will($this->returnValue('foobar'));

        $this->payload->expects($this->once())
                      ->method('findClaimByName')
                      ->with(NotBefore::NAME)
                      ->will($this->returnValue($notBeforeClaim));

        $this->verifier->verify($this->token);
    }

    public function testValid()
    {
        $past = new \DateTime('5 minutes ago', new \DateTimeZone('UTC'));

        $notBeforeClaim = $this->getMockBuilder('Emarref\Jwt\Claim\NotBefore')->getMock();

        $notBeforeClaim->expects($this->exactly(2))
            ->method('getValue')
            ->will($this->returnValue($past->getTimestamp()));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(NotBefore::NAME)
            ->will($this->returnValue($notBeforeClaim));

        $this->verifier->verify($this->token);
    }
}

<?php

namespace Emarref\Jwt\Verification;

use Emarref\Jwt\Claim;

class SubjectVerifierTest extends \PHPUnit_Framework_TestCase
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
     * @expectedExceptionMessage Cannot verify invalid subject value.
     */
    public function testInvalidSubject()
    {
        new SubjectVerifier(new \stdClass());
    }

    public function testNoSubject()
    {
        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Subject::NAME)
            ->will($this->returnValue(null));

        $verifier = new SubjectVerifier();
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidSubjectException
     * @expectedExceptionMessage Subject is invalid.
     */
    public function testSubjectInPayloadOnly()
    {
        $subjectClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Subject')
            ->getMock();

        $subjectClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('a_subject'));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Subject::NAME)
            ->will($this->returnValue($subjectClaim));

        $verifier = new SubjectVerifier();
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidSubjectException
     * @expectedExceptionMessage Subject is invalid.
     */
    public function testSubjectInContextOnly()
    {
        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Subject::NAME)
            ->will($this->returnValue(null));

        $verifier = new SubjectVerifier('a_subject');
        $verifier->verify($this->token);
    }

    /**
     * @expectedException \Emarref\Jwt\Exception\InvalidSubjectException
     * @expectedExceptionMessage Subject is invalid.
     */
    public function testSubjectMismatch()
    {
        $subjectClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Subject')
            ->getMock();

        $subjectClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('a_subject'));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Subject::NAME)
            ->will($this->returnValue($subjectClaim));

        $verifier = new SubjectVerifier('some_other_subject');
        $verifier->verify($this->token);
    }

    public function testSuccess()
    {
        $subjectClaim = $this->getMockBuilder('Emarref\Jwt\Claim\Subject')
            ->getMock();

        $subjectClaim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('a_subject'));

        $this->token->expects($this->once())
            ->method('getPayload')
            ->will($this->returnValue($this->payload));

        $this->payload->expects($this->once())
            ->method('findClaimByName')
            ->with(Claim\Subject::NAME)
            ->will($this->returnValue($subjectClaim));

        $verifier = new SubjectVerifier('a_subject');
        $verifier->verify($this->token);
    }
}
